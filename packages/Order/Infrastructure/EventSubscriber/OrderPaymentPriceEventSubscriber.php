<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\EventSubscriber;

use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Domain\Event\OrderCreated;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/** @SuppressWarnings(PHPMD.LongVariable) */
final class OrderPaymentPriceEventSubscriber implements EventSubscriberInterface
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(
        ShippingMethodPricingRepository $shippingMethodPricingRepository
    ) {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /** @return array<string, array<int, array<int, int|string>>> */
    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreated::class => [
                ['calculatePaymentPrice', 10],
            ],
        ];
    }

    public function calculatePaymentPrice(OrderCreated $orderCreatedEvent): void
    {
        $order = $orderCreatedEvent->getOrder();
        $payment = $order->getPayment();

        if ($payment->getPaymentMethod() !== PaymentMethod::get(PaymentMethod::CASH)) {
            return;
        }

        $shipment = $order->getShipment();
        $paymentPrice = $this->shippingMethodPricingRepository->findByShippingMethodAndCurrencyCode(
            $shipment->getShippingMethod(),
            $order->getCurrency()->getCode()
        );

        if (!$paymentPrice) {
            return;
        }

        $payment->setPrice($paymentPrice->getCashOnDeliveryFee());
    }
}
