<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Enum\OrderOrigin;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class OrderModel implements ModelInterface
{
    public ClientInterface $client;
    public ?ClientCarInterface $clientCar = null;
    public ShippingMethod $shippingMethod;
    public PaymentMethod $paymentMethod;
    public OrderOrigin $origin;
    public ?int $extraSale = null;
    public string $currency;

    /** @var array<int, OrderItemModel> $items */
    public array $items;

    /** @param OrderInterface $entity */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $model = new self();

        $model->client = $entity->getClient();
        $model->clientCar = $entity->getClientCar();
        $model->shippingMethod = $entity->getShipment()->getShippingMethod();
        $model->paymentMethod = $entity->getPayment()->getPaymentMethod();
        $model->origin = $entity->getOrigin();
        $model->extraSale = $entity->getExtraSale();
        $model->currency = $entity->getCurrency()->getCode();

        return $model;
    }

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
