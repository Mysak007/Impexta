<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Factory;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItem;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderRepository;

final class StockWarehouseOrderFactory
{
    private WarehouseOrderRepository $orderRepository;

    public function __construct(
        WarehouseOrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /** @param array<int, array<mixed>> $orderItems */
    public function create(Warehouse $warehouse, array $orderItems, AdminUserInterface $adminUser): void
    {
        $warehouseOrder = new WarehouseOrder($warehouse, $adminUser);

        foreach ($orderItems as $orderItem) {
            $warehouseOrderItem = new WarehouseOrderItem(
                $warehouseOrder,
                $orderItem['leastProduct'],
                ($orderItem['productLeastInStock'] - $orderItem['warehouseProductCount'] + 1),
                ''
            );
            $warehouseOrder->addItem($warehouseOrderItem);
        }

        $this->orderRepository->save($warehouseOrder);
    }
}
