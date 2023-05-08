<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class OrderItem implements OrderItemInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private OrderInterface $order;
    private ProductInterface $product;
    private int $quantity;
    private Money $unitPrice;

    /** @var ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    private Collection $warehouseProducts;

    public function __construct(
        OrderInterface $order,
        ProductInterface $product,
        int $quantity,
        Money $unitPrice
    ) {
        $this->order = $order;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->warehouseProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(Money $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /** @return ArrayCollection<int, WarehouseProductInterface> */
    public function getWarehouseProducts(): Collection
    {
        return $this->warehouseProducts;
    }

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->add($warehouseProduct);
    }

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->removeElement($warehouseProduct);
    }

    /** @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void
    {
        $this->warehouseProducts = $warehouseProducts;
    }
}
