<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Domain\Enum\PaymentState;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface PaymentInterface extends EntityInterface
{
    public function getOnlinePayment(): ?OnlinePaymentInterface;

    public function setOnlinePayment(?OnlinePaymentInterface $onlinePayment): void;

    public function getState(): PaymentState;

    public function setState(PaymentState $state): void;

    public function getPaymentMethod(): PaymentMethod;

    public function setPaymentMethod(PaymentMethod $method): void;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;
}
