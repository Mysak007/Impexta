<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderItemState;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class WarehouseOrderItem implements WarehouseOrderItemInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private WarehouseOrderInterface $warehouseOrder;
    private WarehouseOrderItemState $state;
    private ProductInterface $product;
    private int $quantity;
    private string $supplier;

    public function __construct(
        WarehouseOrderInterface $warehouseOrder,
        ProductInterface $product,
        int $quantity,
        string $supplier
    ) {
        $this->warehouseOrder = $warehouseOrder;
        $this->state = WarehouseOrderItemState::get(WarehouseOrderItemState::CREATED);
        $this->product = $product;
        $this->quantity = $quantity;
        $this->supplier = $supplier;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWarehouseOrder(): WarehouseOrderInterface
    {
        return $this->warehouseOrder;
    }

    public function getState(): WarehouseOrderItemState
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = WarehouseOrderItemState::get($state);
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getSupplier(): string
    {
        return $this->supplier;
    }

    public function setSupplier(string $supplier): void
    {
        $this->supplier = $supplier;
    }
}
