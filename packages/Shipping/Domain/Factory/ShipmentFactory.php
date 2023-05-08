<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Factory;

use Impexta\Shipping\Domain\Entity\Shipment;
use Impexta\Shipping\Domain\Entity\ShipmentInterface;
use Impexta\Shipping\Domain\Enum\ShipmentState;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Money\Currency;
use Money\Money;

final class ShipmentFactory
{
    public function createFree(ShippingMethod $shippingMethod, Currency $currency): ShipmentInterface
    {
        return new Shipment(
            ShipmentState::get(ShipmentState::NEW),
            $shippingMethod,
            new Money(0, $currency)
        );
    }
}
