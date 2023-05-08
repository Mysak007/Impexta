<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Factory;

use Impexta\Warehouse\Domain\Entity\WarehouseOrderInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItem;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseOrderItemModel;

final class WarehouseOrderItemFactory
{
    public function create(
        WarehouseOrderItemModel $warehouseOrderItemModel,
        WarehouseOrderInterface $warehouseOrder
    ): WarehouseOrderItem {
        return new WarehouseOrderItem(
            $warehouseOrder,
            $warehouseOrderItemModel->product,
            $warehouseOrderItemModel->quantity,
            $warehouseOrderItemModel->supplier
        );
    }
}
