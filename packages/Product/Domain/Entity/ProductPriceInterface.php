<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Impexta\Client\Domain\Enum\ClientGroup;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface ProductPriceInterface extends EntityInterface
{
    public function getId(): int;

    public function getProduct(): ProductInterface;

    public function getClientGroup(): ?ClientGroup;

    public function setClientGroup(?ClientGroup $clientGroup): void;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;
}
