<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Factory;

use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Entity\OrderItem;
use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Order\Presentation\Form\Model\OrderItemModel;
use Impexta\Product\Infrastructure\Calculator\ProductPriceCalculator;

final class OrderItemFactory
{
    private ProductPriceCalculator $priceCalculator;

    public function __construct(ProductPriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function create(OrderItemModel $orderItemModel, OrderInterface $order): OrderItemInterface
    {
        $unitPrice = $this->priceCalculator->getPriceWithVat(
            $orderItemModel->product,
            $order->getCurrency(),
            null
        );

        return new OrderItem(
            $order,
            $orderItemModel->product,
            $orderItemModel->quantity,
            $unitPrice
        );
    }
}
