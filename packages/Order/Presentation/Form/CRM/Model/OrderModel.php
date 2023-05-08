<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Form\CRM\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class OrderModel implements ModelInterface
{
    /** @Assert\NotBlank(message="Musíte vybrat klienta") */
    public ClientInterface $client;
    public ?ClientCarInterface $clientCar = null;
    public ShippingMethod $shippingMethod;
    public PaymentMethod $paymentMethod;
    public ?ClientShippingAddressInterface $selectedShippingAddress = null;
    public ?ClientShippingAddressModel $filledInShippingAddress = null;
    public ?int $extraSale = null;
    public string $currency;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, OrderItemModel>
     */
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
        $model->shippingMethod = $entity->getShipment()->getShippingMethod();
        $model->paymentMethod = $entity->getPayment()->getPaymentMethod();
        $model->currency = $entity->getCurrency()->getCode();
        $clientCar = $entity->getClientCar();
        $clientShippingAddress = $entity->getShippingAddress();
        $extraSale = $entity->getExtraSale();

        if ($clientCar) {
            $model->clientCar = $entity->getClientCar();
        }

        if ($clientShippingAddress) {
            $model->selectedShippingAddress = $clientShippingAddress;
        }

        if ($extraSale) {
            $model->extraSale = $entity->getExtraSale();
        }

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
