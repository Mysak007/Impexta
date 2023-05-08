<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Domain\Enum\PaymentState;
use LogicException;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class Payment implements PaymentInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ?OnlinePaymentInterface $onlinePayment;
    private PaymentState $state;
    private PaymentMethod $method;
    private Money $price;

    public function __construct(
        PaymentState $state,
        PaymentMethod $method,
        Money $price
    ) {
        $this->state = $state;
        $this->method = $method;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOnlinePayment(): ?OnlinePaymentInterface
    {
        if ($this->method !== PaymentMethod::get(PaymentMethod::ONLINE)) {
            throw new LogicException(
                sprintf(
                    'Cannot get online payment for payment id "%s" with method "%s"',
                    $this->getId(),
                    PaymentMethod::get($this->method->getReadable())
                )
            );
        }

        if ($this->method === PaymentMethod::get(PaymentMethod::ONLINE) && $this->onlinePayment === null) {
            throw new LogicException(sprintf('online payment not initialized for payment id "%s"', $this->getId()));
        }

        return $this->onlinePayment;
    }

    public function setOnlinePayment(?OnlinePaymentInterface $onlinePayment): void
    {
        $this->onlinePayment = $onlinePayment;
    }

    public function getState(): PaymentState
    {
        return $this->state;
    }

    public function setState(PaymentState $state): void
    {
        $this->state = $state;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->method;
    }

    public function setPaymentMethod(PaymentMethod $method): void
    {
        $this->method = $method;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }
}
