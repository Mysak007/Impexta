<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use App\Eshop\Enum\Country;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Factory\ClientShippingAddressFactory;
use Impexta\Client\Infrastructure\Repository\ClientShippingAddressRepository;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;
use Impexta\Client\Presentation\Form\Type\ClientShippingAddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateShippingAddressController extends AbstractController
{
    private ClientShippingAddressFactory $shippingAddressFactory;
    private ClientShippingAddressRepository $shippingAddressRepository;

    public function __construct(
        ClientShippingAddressFactory $shippingAddressFactory,
        ClientShippingAddressRepository $shippingAddressRepository
    ) {
        $this->shippingAddressFactory = $shippingAddressFactory;
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /** @Route("zakaznik/{id}/dorucovaci-adresa/vytvorit",
     *     name="client_crm_client_shipping_address_create",
     *     requirements={"id"="\d+"}) */
    public function __invoke(Client $client, Request $request): Response
    {
        $model = ClientShippingAddressModel::createEmpty();
        $form = $this->createForm(ClientShippingAddressType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newShippingAddress = $this->shippingAddressFactory->create($model, $client);

            $client->addShippingAddress($newShippingAddress);
            $this->shippingAddressRepository->save($newShippingAddress);

            return $this->redirectToRoute('client_crm_client_detail', ['id' => $client->getId()]);
        }

        return $this->render('@client/CRM/client_shipping_address_create.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
            'country_code' => Country::getCode($client->getCountry()),
        ]);
    }
}
