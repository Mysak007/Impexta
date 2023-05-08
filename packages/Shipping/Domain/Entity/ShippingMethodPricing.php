<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Entity;

use App\Eshop\Enum\Country;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Impexta\Shipping\Presentation\Form\Model\ShippingMethodPricingModel;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class ShippingMethodPricing implements ShippingMethodPricingInterface, HasModelInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;
    private ?string $description;
    private ShippingMethod $shippingMethod;
    private Country $country;
    private Money $price;
    private ?int $overWeightLimit = null;
    private Money $overWeightPrice;
    private Money $cashOnDeliveryFee;

    public function __construct(
        string $name,
        ShippingMethod $shippingMethod,
        Country $country,
        Money $price,
        Money $overWeightPrice,
        Money $cashOnDeliveryFee
    ) {
        $this->name = $name;
        $this->shippingMethod = $shippingMethod;
        $this->country = $country;
        $this->price = $price;
        $this->overWeightPrice = $overWeightPrice;
        $this->cashOnDeliveryFee = $cashOnDeliveryFee;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getShippingMethod(): ShippingMethod
    {
        return $this->shippingMethod;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getOverWeightLimit(): ?int
    {
        return $this->overWeightLimit;
    }

    public function setOverWeightLimit(?int $overWeightLimit): void
    {
        $this->overWeightLimit = $overWeightLimit;
    }

    public function getOverWeightPrice(): Money
    {
        return $this->overWeightPrice;
    }

    public function setOverWeightPrice(Money $overWeightPrice): void
    {
        $this->overWeightPrice = $overWeightPrice;
    }

    /**
     * @param ShippingMethodPricingModel $model
     */
    public function populateFromModel(ModelInterface $model): void
    {
        $this->name = $model->name;
        $this->description = $model->description;
        $this->shippingMethod = $model->shippingMethod;
        $this->country = $model->country;
        $this->price = $model->price;
        $this->overWeightLimit = $model->overWeightLimit;
        $this->overWeightPrice = $model->overWeightPrice;
    }

    public function getCashOnDeliveryFee(): Money
    {
        return $this->cashOnDeliveryFee;
    }

    public function setCashOnDeliveryFee(Money $cashOnDeliveryFee): void
    {
        $this->cashOnDeliveryFee = $cashOnDeliveryFee;
    }
}
