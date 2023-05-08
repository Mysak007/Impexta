<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Facade;

use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Car\Infrastructure\Repository\CarManufacturerRepository;

final class CarManufacturerFacade
{
    private CarManufacturerRepository $carManufacturerRepository;

    public function __construct(
        CarManufacturerRepository $carManufacturerRepository
    ) {
        $this->carManufacturerRepository = $carManufacturerRepository;
    }

    public function getCarManufacturerByName(string $name): CarManufacturer
    {
        $manufacturer = $this->carManufacturerRepository->findOneBy(['name' => $name]);

        if (!$manufacturer) {
            $manufacturer = new CarManufacturer($name);
            $this->carManufacturerRepository->save($manufacturer);
        }

        return $manufacturer;
    }
}
