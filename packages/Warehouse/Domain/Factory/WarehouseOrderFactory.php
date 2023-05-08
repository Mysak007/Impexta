<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Factory;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseOrderModel;

final class WarehouseOrderFactory
{
    private WarehouseOrderItemFactory $warehouseOrderItemFactory;

    public function __construct(
        WarehouseOrderItemFactory $warehouseOrderItemFactory
    ) {
        $this->warehouseOrderItemFactory = $warehouseOrderItemFactory;
    }

    public function create(WarehouseOrderModel $warehouseOrderModel, AdminUserInterface $adminUser): WarehouseOrder
    {
        $warehouseOrder = new WarehouseOrder(
            $warehouseOrderModel->warehouse,
            $adminUser
        );

        foreach ($warehouseOrderModel->warehouseOrderItems as $warehouseOrderItemModel) {
            $warehouseOrderItem = $this->warehouseOrderItemFactory->create($warehouseOrderItemModel, $warehouseOrder);
            $warehouseOrder->addItem($warehouseOrderItem);
        }

        return $warehouseOrder;
    }
}
