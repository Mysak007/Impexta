<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Entity;

use Impexta\Car\Domain\Enum\CarCategory;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface CarInterface extends EntityInterface
{
    public function getId(): int;

    public function getManufacturer(): CarManufacturer;

    public function setManufacturer(CarManufacturer $manufacturer): void;

    public function getModel(): string;

    public function setModel(string $model): void;

    public function getYearOfManufacture(): int;

    public function setYearOfManufacture(int $yearOfManufacture): void;

    public function getEngineCapacity(): float;

    public function setEngineCapacity(float $engineCapacity): void;

    public function getCarCategory(): CarCategory;

    public function setCarCategory(CarCategory $category): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    public function isHideOnEshop(): bool;

    public function setHideOnEshop(bool $hideOnEshop): void;

    public function __toString(): string;
}
