<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\CRM\Model;

use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

final class OrderItemModel
{
    public ProductInterface $product;
    public int $quantity;
    public Money $unitPrice;

    public static function createEmpty(): self
    {
        return new self();
    }

    /** @param OrderItemInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = new self();

        $model->product = $entity->getProduct();
        $model->quantity = $entity->getQuantity();
        $model->unitPrice = $entity->getUnitPrice();

        return $model;
    }
}
