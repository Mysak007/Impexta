<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface CarManufacturerInterface extends EntityInterface
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function isShowOnEshop(): bool;

    public function setShowOnEshop(bool $showOnEshop): void;
}
