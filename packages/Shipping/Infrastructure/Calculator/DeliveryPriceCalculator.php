<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Money\Money;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class DeliveryPriceCalculator
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(ShippingMethodPricingRepository $shippingMethodPricingRepository)
    {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /**
     * @param ArrayCollection<int, OrderItemInterface> $orderItems
     */
    public function calculateDeliveryPrice(OrderInterface $order, Collection $orderItems): Money
    {
        $shippingMethodPricing = $this->shippingMethodPricingRepository->findByShippingMethodAndCurrencyCode(
            ShippingMethod::get(ShippingMethod::DELIVERY),
            $order->getCurrency()->getCode()
        );

        if (!$shippingMethodPricing) {
            throw new ShipmentPriceCalculatorException($order);
        }

        $packagesCount = 0;
        $weight = 0;

        foreach ($orderItems as $orderItem) {
            if ($orderItem->getProduct()->doesNeedsExtraShipping() === true) {
                $packagesCount += $orderItem->getQuantity();

                continue;
            }

            $weight += $orderItem->getProduct()->getWeight() * $orderItem->getQuantity();
        }

        // If at least one item does not require extra shipping then add package with these normal items
        if ($weight > 0) {
            ++$packagesCount;
        }

        $price = $shippingMethodPricing->getPrice()->multiply($packagesCount);

        if (!$shippingMethodPricing->getOverWeightLimit() || $weight <= $shippingMethodPricing->getOverWeightLimit()) {
            return $price;
        }

        $overWeight = ceil($weight - $shippingMethodPricing->getOverWeightLimit());
        $overWeightPrice = $shippingMethodPricing->getOverWeightPrice()->multiply($overWeight);

        return $price->add($overWeightPrice);
    }
}
