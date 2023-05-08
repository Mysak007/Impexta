<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\Model;

use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class OrderItemModel implements ModelInterface
{
    public ProductInterface $product;
    public int $quantity;

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }

    /** @param OrderItemInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = new self();

        $model->product = $entity->getProduct();
        $model->quantity = $entity->getQuantity();

        return $model;
    }
}
