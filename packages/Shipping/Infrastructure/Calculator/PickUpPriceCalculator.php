<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Money\Money;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class PickUpPriceCalculator
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(ShippingMethodPricingRepository $shippingMethodPricingRepository)
    {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    public function calculatePickUpPrice(OrderInterface $order): Money
    {
        $shippingMethodPricing = $this->shippingMethodPricingRepository->findByShippingMethodAndCurrencyCode(
            ShippingMethod::get(ShippingMethod::PICK_UP),
            $order->getCurrency()->getCode()
        );

        if (!$shippingMethodPricing) {
            throw new ShipmentPriceCalculatorException($order);
        }

        return $shippingMethodPricing->getPrice();
    }
}
