<?php

declare(strict_types=1);

namespace Impexta\Car\Api\Controller\CRM;

use Impexta\Car\Api\Factory\CarManufacturerModelsModelFactory;
use Impexta\Car\Domain\Entity\CarManufacturer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetManufacturerModels
{
    private SerializerInterface $serializer;
    private CarManufacturerModelsModelFactory $carModelFactory;

    public function __construct(SerializerInterface $serializer, CarManufacturerModelsModelFactory $carModelFactory)
    {
        $this->serializer = $serializer;
        $this->carModelFactory = $carModelFactory;
    }

    /**
     * @Route("/car/manufacturer/{id}/models")
     */
    public function __invoke(CarManufacturer $manufacturer): JsonResponse
    {
        $carManufacturerModelsModel = $this->carModelFactory->create($manufacturer);

        return new JsonResponse(
            $this->serializer->serialize($carManufacturerModelsModel, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
