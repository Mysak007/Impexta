<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class WarehouseProduct implements WarehouseProductInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private Product $product;
    private Warehouse $warehouse;
    private Money $purchasePrice;

    public function __construct(
        Product $product,
        Warehouse $warehouse,
        Money $purchasePrice
    ) {
        $this->product = $product;
        $this->warehouse = $warehouse;
        $this->purchasePrice = $purchasePrice;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    public function getPurchasePrice(): Money
    {
        return $this->purchasePrice;
    }
}
