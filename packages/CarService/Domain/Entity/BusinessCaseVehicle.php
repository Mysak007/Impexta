<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use Impexta\Client\Domain\Entity\ClientCarInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class BusinessCaseVehicle implements BusinessCaseVehicleInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientCarInterface $clientCar;
    private ?int $fuelState;
    private ?string $note;

    public function __construct(ClientCarInterface $clientCar)
    {
        $this->clientCar = $clientCar;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientCar(): ClientCarInterface
    {
        return $this->clientCar;
    }

    public function setClientCar(ClientCarInterface $clientCar): void
    {
        $this->clientCar = $clientCar;
    }

    public function getFuelState(): ?int
    {
        return $this->fuelState;
    }

    public function setFuelState(?int $fuelState): void
    {
        $this->fuelState = $fuelState;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }
}
