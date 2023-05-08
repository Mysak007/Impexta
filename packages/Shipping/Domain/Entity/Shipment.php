<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Entity;

use Impexta\Shipping\Domain\Enum\ShipmentState;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class Shipment implements ShipmentInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ShipmentState $state;
    private ShippingMethod $method;
    private Money $price;
    private ?string $trackingCode = null;

    public function __construct(
        ShipmentState $state,
        ShippingMethod $method,
        Money $price
    ) {
        $this->state = $state;
        $this->method = $method;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getState(): ShipmentState
    {
        return $this->state;
    }

    public function setState(ShipmentState $state): void
    {
        $this->state = $state;
    }

    public function getShippingMethod(): ShippingMethod
    {
        return $this->method;
    }

    public function setShippingMethod(ShippingMethod $method): void
    {
        $this->method = $method;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getTrackingCode(): ?string
    {
        return $this->trackingCode;
    }

    public function setTrackingCode(?string $trackingCode): void
    {
        $this->trackingCode = $trackingCode;
    }
}
