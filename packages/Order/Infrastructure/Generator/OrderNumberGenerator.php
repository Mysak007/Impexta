<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Generator;

use Impexta\Order\Infrastructure\Repository\OrderRepository;

final class OrderNumberGenerator
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function generateOrderNumber(): string
    {
        $lastOrder = $this->orderRepository->findOneBy([], ['id' => 'DESC']);
        $currentYear = date("Y");

        if ($lastOrder) {
            $number = $lastOrder->getId() + 1;

            return $currentYear . $number;
        }

        return (string)$currentYear . 1;
    }
}
