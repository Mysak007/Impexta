<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Impexta\Order\Domain\Enum\OrderOrigin;
use Impexta\Shipping\Domain\Entity\ShipmentInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Currency;
use Ramsey\Uuid\UuidInterface;

interface OrderInterface extends EntityInterface
{
    public function getId(): int;

    public function getClient(): ClientInterface;

    public function getClientCar(): ?ClientCarInterface;

    public function setClientCar(?ClientCarInterface $clientCar): void;

    public function getShipment(): ShipmentInterface;

    public function setShipment(ShipmentInterface $shipment): void;

    public function getPayment(): PaymentInterface;

    public function setPayment(PaymentInterface $payment): void;

    public function getShippingAddress(): ?ClientShippingAddressInterface;

    public function setShippingAddress(?ClientShippingAddressInterface $shippingAddress): void;

    public function getState(): string;

    public function setState(string $state): void;

    public function getOrigin(): OrderOrigin;

    public function setOrigin(OrderOrigin $origin): void;

    public function getNumber(): string;

    public function setNumber(string $number): void;

    public function getToken(): UuidInterface;

    public function setToken(UuidInterface $token): void;

    public function getExtraSale(): ?int;

    public function setExtraSale(?int $extraSale): void;

    public function getCurrency(): Currency;

    public function setCurrency(Currency $currency): void;

    /**
     * @return ArrayCollection<int, OrderItemInterface>
     */
    public function getOrderItems(): Collection;

    public function addOrderItem(OrderItemInterface $orderItem): void;

    /** @param ArrayCollection<int, OrderItemInterface> $orderItems */
    public function setOrderItems(Collection $orderItems): void;
}
