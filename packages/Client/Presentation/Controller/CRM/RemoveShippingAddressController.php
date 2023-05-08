<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Infrastructure\Repository\ClientShippingAddressRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveShippingAddressController extends AbstractController
{
    private ClientShippingAddressRepository $shippingAddressRepository;

    public function __construct(
        ClientShippingAddressRepository $shippingAddressRepository
    ) {
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /**
     * @Route("zakaznik/{id}/dorucovaci-adresa/{address_id}/odstranit",
     *     name="client_crm_client_shipping_address_delete",
     *     requirements={"id"="\d+"})
     * @ParamConverter("shippingAddress", options={"id" = "address_id"})
     */
    public function __invoke(Client $client, ClientShippingAddress $shippingAddress): Response
    {
        $client->removeShippingAddress($shippingAddress);
        $this->shippingAddressRepository->removeAndSave($shippingAddress);

        $this->addFlash('success', 'Zasílací adresa byla odstraněna');

        return $this->redirectToRoute('client_crm_client_detail', [
            'id' => $client->getId(),
        ]);
    }
}
