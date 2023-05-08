<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Model;

use Impexta\CarService\Domain\Entity\BusinessCaseVehicleInterface;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class BusinessCaseVehicleModel implements ModelInterface
{
    public ClientCarInterface $clientCar;
    public ?int $fuelState = null;
    public ?string $note = null;

    /**
     * @param BusinessCaseVehicleInterface $businessCaseVehicle
     */
    public static function createFromEntity(EntityInterface $businessCaseVehicle): self
    {
        $businessCaseVehicleModel = self::createEmpty();
        $businessCaseVehicleModel->clientCar = $businessCaseVehicle->getClientCar();
        $businessCaseVehicleModel->fuelState = $businessCaseVehicle->getFuelState();
        $businessCaseVehicleModel->note = $businessCaseVehicle->getNote();

        return $businessCaseVehicleModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
