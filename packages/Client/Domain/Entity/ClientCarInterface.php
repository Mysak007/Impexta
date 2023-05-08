<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Impexta\Car\Domain\Entity\CarInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientCarInterface extends EntityInterface
{
    public function getId(): int;

    public function getCar(): CarInterface;

    public function setCar(CarInterface $car): void;

    public function getClient(): ClientInterface;

    public function getLicensePlate(): ?string;

    public function setLicensePlate(?string $licensePlate): void;

    public function getVin(): ?string;

    public function setVin(?string $vin): void;

    public function getTechnicalInspectionExpiresAt(): ?\DateTimeImmutable;

    public function setTechnicalInspectionExpiresAt(?\DateTimeImmutable $technicalInspectionExpiresAt): void;

    public function getOwnerName(): ?string;

    public function setOwnerName(?string $ownerName): void;

    public function __toString(): string;
}
