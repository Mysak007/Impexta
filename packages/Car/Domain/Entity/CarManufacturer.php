<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Entity;

use Impexta\Car\Presentation\Form\Model\CarManufacturerModel;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class CarManufacturer implements CarManufacturerInterface, HasModelInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;
    private bool $showOnEshop;

    /** @SuppressWarnings(PHPMD.BooleanArgumentFlag) */
    public function __construct(string $name, bool $showOnEshop = false)
    {
        $this->name = $name;
        $this->showOnEshop = $showOnEshop;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @param CarManufacturerModel $model */
    public function populateFromModel(ModelInterface $model): void
    {
        $this->setName($model->name);
        $this->setShowOnEshop($model->showOnEshop);
    }

    public function isShowOnEshop(): bool
    {
        return $this->showOnEshop;
    }

    public function setShowOnEshop(bool $showOnEshop): void
    {
        $this->showOnEshop = $showOnEshop;
    }
}
