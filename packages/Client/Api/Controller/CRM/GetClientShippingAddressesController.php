<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Controller\CRM;

use Impexta\Client\Api\Factory\ClientShippingAddressesApiModelFactory;
use Impexta\Client\Domain\Entity\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetClientShippingAddressesController
{
    private SerializerInterface $serializer;
    private ClientShippingAddressesApiModelFactory $addressesModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        ClientShippingAddressesApiModelFactory $addressesModelFactory
    ) {
        $this->serializer = $serializer;
        $this->addressesModelFactory = $addressesModelFactory;
    }

    /** @Route("/client/{id}/shipping-addresses") */
    public function __invoke(Client $client): JsonResponse
    {
        $clientShippingAddressModel = $this->addressesModelFactory->create($client);

        return new JsonResponse(
            $this->serializer->serialize($clientShippingAddressModel, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
