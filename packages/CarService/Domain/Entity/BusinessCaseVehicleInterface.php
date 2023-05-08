<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use Impexta\Client\Domain\Entity\ClientCarInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface BusinessCaseVehicleInterface extends EntityInterface
{
    public function getId(): int;

    public function getClientCar(): ClientCarInterface;

    public function setClientCar(ClientCarInterface $clientCar): void;

    public function getFuelState(): ?int;

    public function setFuelState(?int $fuelState): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;
}
