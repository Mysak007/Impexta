<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\EventSubscriber;

use Impexta\Order\Domain\Event\OrderCreated;
use Impexta\Shipping\Infrastructure\Calculator\ShipmentPriceCalculator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class OrderShipmentPriceEventSubscriber implements EventSubscriberInterface
{
    private ShipmentPriceCalculator $shipmentPriceCalculator;

    public function __construct(
        ShipmentPriceCalculator $shipmentPriceCalculator
    ) {
        $this->shipmentPriceCalculator = $shipmentPriceCalculator;
    }

    /** @return array<string, array<int, array<int, int|string>>> */
    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreated::class => [
                ['calculateShipmentPrice', 10],
            ],
        ];
    }

    public function calculateShipmentPrice(OrderCreated $orderCreatedEvent): void
    {
        $order = $orderCreatedEvent->getOrder();
        $shipment = $order->getShipment();
        $shipment->setPrice($this->shipmentPriceCalculator->calculatePrice($order));
    }
}
