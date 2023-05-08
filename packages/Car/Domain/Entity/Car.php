<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Entity;

use Impexta\Car\Domain\Enum\CarCategory;
use Impexta\Car\Presentation\Form\Model\CarModel;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class Car implements CarInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private CarManufacturer $manufacturer;
    private CarCategory $category;
    private string $model;
    private int $yearOfManufacture;
    private float $engineCapacity;
    private ?string $note = null;
    private bool $hideOnEshop;

    /** @SuppressWarnings(PHPMD.BooleanArgumentFlag) */
    public function __construct(
        CarManufacturer $manufacturer,
        CarCategory $category,
        string $model,
        int $yearOfManufacture,
        float $engineCapacity,
        bool $hideOnEshop = true
    ) {
        $this->manufacturer = $manufacturer;
        $this->category = $category;
        $this->model = $model;
        $this->yearOfManufacture = $yearOfManufacture;
        $this->engineCapacity = $engineCapacity;
        $this->hideOnEshop = $hideOnEshop;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getManufacturer(): CarManufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(CarManufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getCarCategory(): CarCategory
    {
        return $this->category;
    }

    public function setCarCategory(CarCategory $category): void
    {
        $this->category = $category;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getYearOfManufacture(): int
    {
        return $this->yearOfManufacture;
    }

    public function setYearOfManufacture(int $yearOfManufacture): void
    {
        $this->yearOfManufacture = $yearOfManufacture;
    }

    public function getEngineCapacity(): float
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(float $engineCapacity): void
    {
        $this->engineCapacity = $engineCapacity;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function isHideOnEshop(): bool
    {
        return $this->hideOnEshop;
    }

    public function setHideOnEshop(bool $hideOnEshop): void
    {
        $this->hideOnEshop = $hideOnEshop;
    }

    public function mapFromModel(CarModel $carModel, CarManufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
        $this->category = $carModel->category;
        $this->model = $carModel->model;
        $this->yearOfManufacture = (int)$carModel->yearOfManufacture;
        $this->engineCapacity = (float)$carModel->engineCapacity;
        $this->note = $carModel->note;
        $this->hideOnEshop = $carModel->hideOnEshop;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s %d, %01.1fL %s',
            $this->getManufacturer()->getName(),
            $this->getModel(),
            $this->getYearOfManufacture(),
            $this->getEngineCapacity(),
            $this->getNote()
        );
    }
}
