<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Entity;

use Impexta\Shipping\Domain\Enum\ShipmentState;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface ShipmentInterface extends EntityInterface
{
    public function getState(): ShipmentState;

    public function setState(ShipmentState $state): void;

    public function getShippingMethod(): ShippingMethod;

    public function setShippingMethod(ShippingMethod $method): void;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;

    public function getTrackingCode(): ?string;

    public function setTrackingCode(?string $trackingCode): void;
}
