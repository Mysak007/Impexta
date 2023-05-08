<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Form\Model;

use App\Eshop\Enum\Country;
use Impexta\Shipping\Domain\Entity\ShippingMethodPricingInterface;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class ShippingMethodPricingModel implements ModelInterface
{
    /**
     * @Assert\NotNull(message="Jméno nesmí být prázdné")
     * @Assert\Length(max=50,maxMessage="Jméno musí mít maximálně 50 znaků")
     */
    public string $name;

    /** @Assert\Length(max=255,maxMessage="Délka musí být maximálně 255 znaků") */
    public ?string $description = null;

    /** @Assert\NotBlank(message="Doprava nesmí být prázdná") */
    public ShippingMethod $shippingMethod;

    /** @Assert\NotBlank(message="Země musí být vyplněna") */
    public Country $country;

    /** @Assert\NotNull(message="hodnota nesmí být prázdná") */
    public Money $price;
    public ?int $overWeightLimit = null;

    /** @Assert\NotNull(message="hodnota nesmí být prázdná") */
    public Money $overWeightPrice;

    /** @Assert\NotNull(message="hodnota nesmí být prázdná") */
    public Money $cashOnDeliveryFee;

    /** @param ShippingMethodPricingInterface $entity */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $pricingModel = self::createEmpty();
        $pricingModel->name = $entity->getName();
        $pricingModel->description = $entity->getDescription();
        $pricingModel->shippingMethod = $entity->getShippingMethod();
        $pricingModel->country = $entity->getCountry();
        $pricingModel->price = $entity->getPrice();
        $pricingModel->overWeightLimit = $entity->getOverWeightLimit();
        $pricingModel->overWeightPrice = $entity->getOverWeightPrice();
        $pricingModel->cashOnDeliveryFee = $entity->getCashOnDeliveryFee();

        return $pricingModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
