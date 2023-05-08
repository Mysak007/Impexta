<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Factory;

use Impexta\CarService\Domain\Entity\BusinessCaseVehicle;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseVehicleModel;

final class BusinessCaseVehicleFactory
{
    public function create(BusinessCaseVehicleModel $model): BusinessCaseVehicle
    {
        $vehicle = new BusinessCaseVehicle($model->clientCar);
        $vehicle->setFuelState($model->fuelState);
        $vehicle->setNote($model->note);

        return $vehicle;
    }
}
