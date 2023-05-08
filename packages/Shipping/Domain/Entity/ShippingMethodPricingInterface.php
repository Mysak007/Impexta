<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Entity;

use App\Eshop\Enum\Country;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface ShippingMethodPricingInterface extends EntityInterface
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getShippingMethod(): ShippingMethod;

    public function getCountry(): Country;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;

    public function getOverWeightLimit(): ?int;

    public function setOverWeightLimit(?int $overWeightLimit): void;

    public function getOverWeightPrice(): Money;

    public function setOverWeightPrice(Money $overWeightPrice): void;

    public function getCashOnDeliveryFee(): Money;

    public function setCashOnDeliveryFee(Money $cashOnDeliveryFee): void;
}
