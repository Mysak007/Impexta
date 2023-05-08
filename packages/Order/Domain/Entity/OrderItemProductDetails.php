<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class OrderItemProductDetails implements OrderItemProductDetailsInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private OrderItemInterface $orderItem;
    private VatRate $vatRate;
    private Guarantee $guarantee;
    private string $code;
    private string $name;
    private string $manufacturer;
    private float $weight;

    public function __construct(
        OrderItemInterface $orderItem,
        VatRate $vatRate,
        Guarantee $guarantee,
        string $code,
        string $name,
        string $manufacturer,
        float $weight
    ) {
        $this->orderItem = $orderItem;
        $this->vatRate = $vatRate;
        $this->guarantee = $guarantee;
        $this->code = $code;
        $this->name = $name;
        $this->manufacturer = $manufacturer;
        $this->weight = $weight;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderItem(): OrderItemInterface
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItem $orderItem): void
    {
        $this->orderItem = $orderItem;
    }

    public function getVatRate(): VatRate
    {
        return $this->vatRate;
    }

    public function setVatRate(VatRate $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    public function getGuarantee(): Guarantee
    {
        return $this->guarantee;
    }

    public function setGuarantee(Guarantee $guarantee): void
    {
        $this->guarantee = $guarantee;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
}
