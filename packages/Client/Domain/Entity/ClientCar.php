<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Impexta\Car\Domain\Entity\CarInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientCar implements ClientCarInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientInterface $client;
    private CarInterface $car;
    private ?string $licensePlate = null;
    private ?string $vin = null;
    private ?\DateTimeImmutable $technicalInspectionExpiresAt = null;
    private ?string $ownerName = null;

    public function __construct(CarInterface $car, ClientInterface $client)
    {
        $this->car = $car;
        $this->client = $client;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCar(): CarInterface
    {
        return $this->car;
    }

    public function setCar(CarInterface $car): void
    {
        $this->car = $car;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(?string $licensePlate): void
    {
        $this->licensePlate = $licensePlate;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): void
    {
        $this->vin = $vin;
    }

    public function getTechnicalInspectionExpiresAt(): ?\DateTimeImmutable
    {
        return $this->technicalInspectionExpiresAt;
    }

    public function setTechnicalInspectionExpiresAt(?\DateTimeImmutable $technicalInspectionExpiresAt): void
    {
        $this->technicalInspectionExpiresAt = $technicalInspectionExpiresAt;
    }

    public function getOwnerName(): ?string
    {
        return $this->ownerName;
    }

    public function setOwnerName(?string $ownerName): void
    {
        $this->ownerName = $ownerName;
    }

    public function __toString(): string
    {
        return $this->getCar()->__toString();
    }
}
