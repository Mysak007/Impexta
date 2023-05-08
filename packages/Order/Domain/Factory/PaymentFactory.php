<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Factory;

use Impexta\Order\Domain\Entity\Payment;
use Impexta\Order\Domain\Entity\PaymentInterface;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Domain\Enum\PaymentState;
use Money\Currency;
use Money\Money;

final class PaymentFactory
{
    public function createFree(PaymentMethod $paymentMethod, Currency $currency): PaymentInterface
    {
        return new Payment(
            PaymentState::get(PaymentState::NEW),
            $paymentMethod,
            new Money(0, $currency)
        );
    }
}
