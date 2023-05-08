<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderItemState;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface WarehouseOrderItemInterface extends EntityInterface
{
    public function getWarehouseOrder(): WarehouseOrderInterface;

    public function getState(): WarehouseOrderItemState;

    public function setState(string $state): void;

    public function getProduct(): ProductInterface;

    public function setProduct(ProductInterface $product): void;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;

    public function getSupplier(): string;

    public function setSupplier(string $supplier): void;
}
