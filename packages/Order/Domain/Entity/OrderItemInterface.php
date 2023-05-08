<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface OrderItemInterface extends EntityInterface
{
    public function getId(): int;

    public function getOrder(): OrderInterface;

    public function getProduct(): ProductInterface;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;

    public function getUnitPrice(): Money;

    public function setUnitPrice(Money $unitPrice): void;

    /** @return ArrayCollection<int, WarehouseProductInterface> */
    public function getWarehouseProducts(): Collection;

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    /** @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void;
}
