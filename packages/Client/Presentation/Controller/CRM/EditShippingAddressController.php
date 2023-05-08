<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use App\Eshop\Enum\Country;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Infrastructure\Mapper\ClientShippingAddressMapper;
use Impexta\Client\Infrastructure\Repository\ClientShippingAddressRepository;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;
use Impexta\Client\Presentation\Form\Type\ClientShippingAddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditShippingAddressController extends AbstractController
{
    private ClientShippingAddressMapper $shippingAddressMapper;
    private ClientShippingAddressRepository $shippingAddressRepository;

    public function __construct(
        ClientShippingAddressMapper $shippingAddressMapper,
        ClientShippingAddressRepository $shippingAddressRepository
    ) {

        $this->shippingAddressMapper = $shippingAddressMapper;
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /**
     * @Route("zakaznik/{id}/dorucovaci-adresa/{address_id}/upravit",
     *     name="client_crm_client_shipping_address_edit",
     *     requirements={"id"="\d+"})
     * @ParamConverter("shippingAddress", options={"id" = "address_id"})
     */
    public function __invoke(Client $client, ClientShippingAddress $shippingAddress, Request $request): Response
    {
        $model = ClientShippingAddressModel::createFromEntity($shippingAddress);
        $form = $this->createForm(ClientShippingAddressType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->shippingAddressMapper->mapFromModel($model, $shippingAddress);
            $this->shippingAddressRepository->save($shippingAddress);

            return $this->redirectToRoute('client_crm_client_detail', ['id' => $client->getId()]);
        }

        return $this->render('@client/CRM/client_shipping_address_edit.html.twig', [
            'client' => $client,
            'shippingAddress' => $client->getDefaultShippingAddress(),
            'form' => $form->createView(),
            'country_code' => Country::getCode($client->getCountry()),
        ]);
    }
}
