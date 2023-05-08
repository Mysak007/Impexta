<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Mapper;

use Impexta\CarService\Domain\Entity\BusinessCaseVehicleInterface;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseVehicleModel;

final class BusinessCaseVehicleMapper
{
    public function mapFromModel(
        BusinessCaseVehicleInterface $businessCaseVehicle,
        BusinessCaseVehicleModel $model
    ): void {
        $businessCaseVehicle->setClientCar($model->clientCar);
        $businessCaseVehicle->setFuelState($model->fuelState);
        $businessCaseVehicle->setNote($model->note);
    }
}
