<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Factory;

use Impexta\Client\Domain\Factory\ClientShippingAddressFactory;
use Impexta\Client\Infrastructure\Repository\ClientShippingAddressRepository;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Entity\InquiryItemOfferInterface;
use Impexta\Inquiry\Presentation\Form\Model\InquiryCreateOrderModel;
use Impexta\Order\Domain\Entity\Order;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Entity\OrderItem;
use Impexta\Order\Domain\Enum\OrderOrigin;
use Impexta\Order\Domain\Enum\OrderState;
use Impexta\Order\Domain\Event\OrderCreatedEvent;
use Impexta\Order\Domain\Model\OrderModel;
use Impexta\Order\Infrastructure\Generator\OrderNumberGenerator;
use Impexta\Shipping\Domain\Factory\ShipmentFactory;
use Impexta\Shipping\Infrastructure\Calculator\ShipmentPriceCalculator;
use Money\Currency;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/** @SuppressWarnings("PHPMD.CouplingBetweenObjects") */
final class OrderFactory
{
    private ShipmentFactory $shipmentFactory;
    private PaymentFactory $paymentFactory;
    private OrderNumberGenerator $orderNumberGenerator;
    private ShipmentPriceCalculator $shipmentPriceCalculator;
    private EventDispatcherInterface $eventDispatcher;
    private ClientShippingAddressFactory $clientShippingAddressFactory;
    private ClientShippingAddressRepository $shippingAddressRepository;

    public function __construct(
        ShipmentFactory $shipmentFactory,
        PaymentFactory $paymentFactory,
        OrderNumberGenerator $orderNumberGenerator,
        ShipmentPriceCalculator $shipmentPriceCalculator,
        EventDispatcherInterface $eventDispatcher,
        ClientShippingAddressFactory $clientShippingAddressFactory,
        ClientShippingAddressRepository $shippingAddressRepository
    ) {
        $this->shipmentFactory = $shipmentFactory;
        $this->paymentFactory = $paymentFactory;
        $this->orderNumberGenerator = $orderNumberGenerator;
        $this->shipmentPriceCalculator = $shipmentPriceCalculator;
        $this->eventDispatcher = $eventDispatcher;
        $this->clientShippingAddressFactory = $clientShippingAddressFactory;
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    public function create(OrderModel $model): OrderInterface
    {
        $shipment = $this->shipmentFactory->createFree($model->shippingMethod, new Currency($model->currency));
        $payment = $this->paymentFactory->createFree($model->paymentMethod, new Currency($model->currency));
        $number = $this->orderNumberGenerator->generateOrderNumber();
        $token = Uuid::uuid4();
        $shippingAddress = $model->shippingAddress ?: null;

        $order = new Order(
            $model->client,
            $shipment,
            $payment,
            OrderState::NEW,
            $model->origin,
            $number,
            $token,
            new Currency($model->currency)
        );

        if ($shippingAddress) {
            if ($this->shippingAddressRepository->findOneBy(['id' => $shippingAddress->getId()])) {
                $order->setShippingAddress($shippingAddress);
            }

            if (!$this->shippingAddressRepository->findOneBy(['id' => $shippingAddress->getId()])) {
                $shippingAddressModel = ClientShippingAddressModel::createFromEntity($shippingAddress);
                $shippingAddress = $this->clientShippingAddressFactory
                    ->create(
                        $shippingAddressModel,
                        $order->getClient()
                    );

                $order->setShippingAddress($shippingAddress);
            }
        }

        if ($model->clientCar) {
            $order->setClientCar($model->clientCar);
        }

        if ($model->extraSale) {
            $order->setExtraSale($model->extraSale);
        }

        $price = $this->shipmentPriceCalculator->calculatePrice($order);
        $shipment->setPrice($price);

        $orderEvent = new OrderCreatedEvent($order);
        $this->eventDispatcher->dispatch($orderEvent);

        return $order;
    }

    public function createFromInquiry(
        Inquiry $inquiry,
        InquiryCreateOrderModel $orderModel
    ): Order {
        $shipment = $this->shipmentFactory->createFree($orderModel->shipment, new Currency('CZK'));
        $payment = $this->paymentFactory->createFree($orderModel->payment, new Currency('CZK'));
        $number = $this->orderNumberGenerator->generateOrderNumber();
        $token = Uuid::uuid4();

        $order = new Order(
            $inquiry->getClient(),
            $shipment,
            $payment,
            OrderState::NEW,
            OrderOrigin::get(OrderOrigin::CRM),
            $number,
            $token,
            $payment->getPrice()->getCurrency(),
        );

        foreach ($orderModel->itemOffers as $offerItem) {
            /** @var InquiryItemOfferInterface $inquiryItemOffer */
            $inquiryItemOffer = $offerItem->inquiryItemOffer;
            $itemRequest = $inquiry->getItemRequests()->filter(static function ($itemRequest)
 use ($offerItem, $inquiryItemOffer) {
                return ($itemRequest->getProductCard() === $inquiryItemOffer->getProduct()->getProductCard()
                    && $offerItem->isSelected === true);
            })->first();

            if (!$itemRequest) {
                continue;
            }

            $orderItem = new OrderItem(
                $order,
                $inquiryItemOffer->getProduct(),
                $itemRequest->getQuantity(),
                $inquiryItemOffer->getPrice()
            );
            $order->addOrderItem($orderItem);
        }

        return $order;
    }
}
