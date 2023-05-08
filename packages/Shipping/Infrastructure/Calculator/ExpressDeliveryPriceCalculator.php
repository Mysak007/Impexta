<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use Doctrine\Common\Collections\ArrayCollection;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Money\Currency;
use Money\Money;

final class ExpressDeliveryPriceCalculator
{
    private DeliveryPriceCalculator $deliveryPriceCalculator;

    public function __construct(DeliveryPriceCalculator $deliveryPriceCalculator)
    {
        $this->deliveryPriceCalculator = $deliveryPriceCalculator;
    }

    public function calculateExpressDeliveryPrice(OrderInterface $order): Money
    {
        $warehouses = [];

        foreach (Warehouse::values() as $warehouse) {
            $warehouses[$warehouse] = new ArrayCollection();
        }

        /** @var OrderItemInterface $orderItem */
        foreach ($order->getOrderItems() as $orderItem) {
            foreach ($orderItem->getWarehouseProducts() as $warehouseProduct) {
                $warehouses[$warehouseProduct->getWarehouse()->getValue()][] = $orderItem;
            }
        }

        $currency = new Currency($order->getCurrency()->getCode());

        /** @var Money $totalPrice */
        $totalPrice = new Money(0, $currency);

        foreach ($warehouses as $warehouse) {
            $totalPrice = $totalPrice->add($this->deliveryPriceCalculator->calculateDeliveryPrice($order, $warehouse));
        }

        return $totalPrice;
    }
}
