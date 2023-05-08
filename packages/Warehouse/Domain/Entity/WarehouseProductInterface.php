<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface WarehouseProductInterface extends EntityInterface
{
    public function getId(): int;

    public function getProduct(): Product;

    public function getWarehouse(): Warehouse;

    public function setWarehouse(Warehouse $warehouse): void;

    public function getPurchasePrice(): Money;
}
