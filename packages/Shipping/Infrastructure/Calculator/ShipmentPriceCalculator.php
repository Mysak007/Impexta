<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Money\Money;

final class ShipmentPriceCalculator
{
    private PickUpPriceCalculator $pickupPriceCalculator;
    private DeliveryPriceCalculator $deliveryPriceCalculator;
    private ExpressDeliveryPriceCalculator $expressDeliveryPriceCalculator;

    public function __construct(
        PickUpPriceCalculator $pickupPriceCalculator,
        DeliveryPriceCalculator $deliveryPriceCalculator,
        ExpressDeliveryPriceCalculator $expressDeliveryPriceCalculator
    ) {
        $this->pickupPriceCalculator = $pickupPriceCalculator;
        $this->deliveryPriceCalculator = $deliveryPriceCalculator;
        $this->expressDeliveryPriceCalculator = $expressDeliveryPriceCalculator;
    }

    public function calculatePrice(OrderInterface $order): Money
    {
        $shipment = $order->getShipment();

        $shippingMethod = $shipment->getShippingMethod()->getValue();

        switch ($shippingMethod) {
            case ShippingMethod::PICK_UP:
                return $this->pickupPriceCalculator->calculatePickUpPrice($order);

            case ShippingMethod::DELIVERY:
                return $this->deliveryPriceCalculator->calculateDeliveryPrice($order, $order->getOrderItems());

            case ShippingMethod::DELIVERY_EXPRESS:
                return $this->expressDeliveryPriceCalculator->calculateExpressDeliveryPrice($order);
        }

        throw new ShipmentPriceCalculatorException($order);
    }
}
