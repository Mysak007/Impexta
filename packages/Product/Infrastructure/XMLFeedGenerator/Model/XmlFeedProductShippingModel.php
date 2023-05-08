<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Model;

use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Money\Currency;
use Money\Money;

final class XmlFeedProductShippingModel
{
    public ShippingMethod $shippingMethod;
    public Money $price;
    public Money $cashOnDeliveryFee;

    public function __construct(ShippingMethod $shippingMethod, Money $price, Money $cashOnDeliveryFee)
    {
        $this->shippingMethod = $shippingMethod;
        $this->price = $price;
        $this->cashOnDeliveryFee = $cashOnDeliveryFee;
    }

    public function getPriceWithCashOnDeliveryFee(): Money
    {
        return $this->price->add($this->cashOnDeliveryFee);
    }

    public function hasPriceInCurrency(Currency $currency): bool
    {
        return $this->price->getCurrency()->getCode() === $currency->getCode();
    }
}
