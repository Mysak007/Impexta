<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface OrderItemProductDetailsInterface extends EntityInterface
{
    public function getOrderItem(): OrderItemInterface;

    public function setOrderItem(OrderItem $orderItem): void;

    public function getVatRate(): VatRate;

    public function setVatRate(VatRate $vatRate): void;

    public function getGuarantee(): Guarantee;

    public function setGuarantee(Guarantee $guarantee): void;

    public function getCode(): string;

    public function setCode(string $code): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getManufacturer(): string;

    public function setManufacturer(string $manufacturer): void;

    public function getWeight(): float;

    public function setWeight(float $weight): void;
}
