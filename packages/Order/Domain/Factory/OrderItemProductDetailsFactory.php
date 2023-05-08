<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Factory;

use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Order\Domain\Entity\OrderItemProductDetails;
use Impexta\Order\Domain\Entity\OrderItemProductDetailsInterface;

final class OrderItemProductDetailsFactory
{
    public function create(OrderItemInterface $orderItem): OrderItemProductDetailsInterface
    {
        $vatRate = $orderItem->getProduct()->getProductCard()->getVatRate();
        $guarantee = $orderItem->getProduct()->getProductCard()->getGuarantee();
        $code = $orderItem->getProduct()->getCode();
        $name = $orderItem->getProduct()->getName();
        $manufacturer = $orderItem->getProduct()->getManufacturer();
        $weight = $orderItem->getProduct()->getWeight();

        return new OrderItemProductDetails(
            $orderItem,
            $vatRate,
            $guarantee,
            $code,
            $name,
            $manufacturer,
            $weight
        );
    }
}
