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
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Currency;
use Ramsey\Uuid\UuidInterface;

class Order implements OrderInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientInterface $client;
    private ?ClientCarInterface $clientCar = null;
    private ShipmentInterface $shipment;
    private PaymentInterface $payment;
    private ?ClientShippingAddressInterface $shippingAddress = null;
    private string $state;
    private OrderOrigin $origin;
    private string $number;
    private UuidInterface $token;
    private ?int $extraSale = null;
    private Currency $currency;

    /** @var ArrayCollection<int,OrderItemInterface> $orderItems */
    private Collection $orderItems;

    /** @SuppressWarnings(PHPMD.ExcessiveParameterList) */
    public function __construct(
        ClientInterface $client,
        ShipmentInterface $shipment,
        PaymentInterface $payment,
        string $state,
        OrderOrigin $origin,
        string $number,
        UuidInterface $token,
        Currency $currency
    ) {
        $this->client = $client;
        $this->shipment = $shipment;
        $this->payment = $payment;
        $this->state = $state;
        $this->origin = $origin;
        $this->number = $number;
        $this->token = $token;
        $this->currency = $currency;
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getToken(): UuidInterface
    {
        return $this->token;
    }

    public function setToken(UuidInterface $token): void
    {
        $this->token = $token;
    }

    public function getOrderOrigin(): OrderOrigin
    {
        return $this->origin;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getExtraSale(): ?int
    {
        return $this->extraSale;
    }

    public function setExtraSale(?int $extraSale): void
    {
        $this->extraSale = $extraSale;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getShipment(): ShipmentInterface
    {
        return $this->shipment;
    }

    public function setShipment(ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }

    public function getClientCar(): ?ClientCarInterface
    {
        return $this->clientCar;
    }

    public function setClientCar(?ClientCarInterface $clientCar): void
    {
        $this->clientCar = $clientCar;
    }

    public function getPayment(): PaymentInterface
    {
        return $this->payment;
    }

    public function setPayment(PaymentInterface $payment): void
    {
        $this->payment = $payment;
    }

    public function getShippingAddress(): ?ClientShippingAddressInterface
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?ClientShippingAddressInterface $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getOrigin(): OrderOrigin
    {
        return $this->origin;
    }

    public function setOrigin(OrderOrigin $origin): void
    {
        $this->origin = $origin;
    }

    /**
     * @return ArrayCollection<int, OrderItemInterface>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItemInterface $orderItem): void
    {
        $this->getOrderItems()->add($orderItem);
    }

    /** @param ArrayCollection<int, OrderItemInterface> $orderItems */
    public function setOrderItems(Collection $orderItems): void
    {
        $this->orderItems = $orderItems;
    }
}
