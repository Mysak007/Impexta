<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Controller\CRM;

use Impexta\Client\Api\Factory\ClientCarsModelFactory;
use Impexta\Client\Domain\Entity\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetClientCarsController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/client/{id}/cars")
     */
    public function __invoke(Client $client): JsonResponse
    {
        $clientCarsModel = ClientCarsModelFactory::create($client);

        return new JsonResponse(
            $this->serializer->serialize($clientCarsModel, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
