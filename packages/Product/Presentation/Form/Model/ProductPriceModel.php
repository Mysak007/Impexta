<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Product\Domain\Entity\ProductPriceInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;

final class ProductPriceModel implements ModelInterface
{
    public Money $price;
    public ?ClientGroup $clientGroup = null;

    /** @param ProductPriceInterface $productPrice */
    public static function createFromEntity(EntityInterface $productPrice): self
    {
        $model = new self();

        $model->price = $productPrice->getPrice();
        $model->clientGroup = $productPrice->getClientGroup();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
