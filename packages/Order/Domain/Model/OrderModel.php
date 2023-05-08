<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
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
    public ?ClientShippingAddressInterface $shippingAddress = null;
    public OrderOrigin $origin;
    public ?int $extraSale = null;
    public string $currency;

    /** @var ArrayCollection<int, OrderItemModel> $items */
    public Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /** @param OrderInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
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

    public static function createEmpty(): self
    {
        return new self();
    }
}
