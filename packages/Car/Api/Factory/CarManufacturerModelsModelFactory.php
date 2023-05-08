<?php

declare(strict_types=1);

namespace Impexta\Car\Api\Factory;

use Impexta\Car\Api\Model\CarManufacturerModelsModel;
use Impexta\Car\Domain\Entity\CarManufacturerInterface;
use Impexta\Car\Infrastructure\Repository\CarRepository;

final class CarManufacturerModelsModelFactory
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function create(CarManufacturerInterface $manufacturer): CarManufacturerModelsModel
    {
        $carModels = $this->carRepository->findUniqueModelsByManufacturer($manufacturer);

        return new CarManufacturerModelsModel($carModels);
    }
}
