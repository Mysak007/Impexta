<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use Impexta\Order\Domain\Entity\OrderInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface ShipmentPriceCalculatorInterface extends EntityInterface
{
    public function calculatePrice(OrderInterface $order): Money;
}
