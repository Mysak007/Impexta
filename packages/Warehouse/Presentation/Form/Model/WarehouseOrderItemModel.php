<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Model;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItemInterface;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderItemState;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class WarehouseOrderItemModel implements ModelInterface
{
    public WarehouseOrderItemState $state;
    public ProductInterface $product;
    public string $supplier;

    /** @Assert\NotBlank(message="Množství nesmí být prázdné") */
    public int $quantity;

    /**
     * @param WarehouseOrderItemInterface $entity
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $warehouseOrderItemModel = new self();
        $warehouseOrderItemModel->state = $entity->getState();
        $warehouseOrderItemModel->product = $entity->getProduct();
        $warehouseOrderItemModel->quantity = $entity->getQuantity();
        $warehouseOrderItemModel->supplier = $entity->getSupplier();

        return $warehouseOrderItemModel;
    }

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
