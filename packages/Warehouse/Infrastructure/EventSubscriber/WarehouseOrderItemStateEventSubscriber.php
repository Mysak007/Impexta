<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\EventSubscriber;

use Impexta\Warehouse\Domain\Entity\WarehouseOrderItemInterface;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\EnteredEvent;

final class WarehouseOrderItemStateEventSubscriber implements EventSubscriberInterface
{
    /**
     * @return array<string|object, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.warehouse_order_item.enter.received' => 'onWarehouseOrderItemReceived',
        ];
    }

    public function onWarehouseOrderItemReceived(EnteredEvent $event): void
    {
        /**
         * @var WarehouseOrderItemInterface $workflowWarehouseOrderItem
         */
        $workflowWarehouseOrderItem = $event->getSubject();
        $warehouseOrder = $workflowWarehouseOrderItem->getWarehouseOrder();

        if ($warehouseOrder->getState() !== WarehouseOrderState::ORDERED) {
            return;
        }

        // If not all items are received, then order is only partially received
        if ($warehouseOrder->getOrderItems()->count() > $warehouseOrder->getReceivedOrderItems()->count()) {
            $warehouseOrder->setState(WarehouseOrderState::PARTIALLY_RECEIVED);

            return;
        }

        $warehouseOrder->setState(WarehouseOrderState::RECEIVED);
    }
}
