<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Factory;

use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Car\Presentation\Form\Model\CarManufacturerModel;

final class CarManufacturerFactory
{
    public function create(string $name): CarManufacturer
    {
        return new CarManufacturer($name);
    }

    public function createFromModel(CarManufacturerModel $carManufacturerModel): CarManufacturer
    {
        return new CarManufacturer($carManufacturerModel->name, $carManufacturerModel->showOnEshop);
    }
}
