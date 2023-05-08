<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Event;

use Impexta\Order\Domain\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

final class OrderCreated extends Event
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
