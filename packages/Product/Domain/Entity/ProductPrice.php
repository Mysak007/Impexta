<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Impexta\Client\Domain\Enum\ClientGroup;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class ProductPrice implements ProductPriceInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ProductInterface $product;
    private ?ClientGroup $clientGroup = null;
    private Money $price;

    public function __construct(
        ProductInterface $product,
        Money $price
    ) {
        $this->product = $product;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getClientGroup(): ?ClientGroup
    {
        return $this->clientGroup;
    }

    public function setClientGroup(?ClientGroup $clientGroup): void
    {
        $this->clientGroup = $clientGroup;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }
}
