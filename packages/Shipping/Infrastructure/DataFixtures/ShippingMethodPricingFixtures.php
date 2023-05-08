<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\DataFixtures;

use App\Eshop\Enum\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Shipping\Domain\Entity\ShippingMethodPricing;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Money\Currency;
use Money\Money;

final class ShippingMethodPricingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currency = new Currency('CZK');
        $money = new Money(100, $currency);

        $shippingMethodPricing1 = new ShippingMethodPricing(
            'Vyzvednutí',
            ShippingMethod::get(ShippingMethod::PICK_UP),
            Country::get(Country::CZECHIA),
            $money,
            $money,
            $money
        );
        $manager->persist($shippingMethodPricing1);

        $shippingMethodPricing2 = new ShippingMethodPricing(
            'Doručení',
            ShippingMethod::get(ShippingMethod::DELIVERY),
            Country::get(Country::CZECHIA),
            $money,
            $money,
            $money
        );
        $manager->persist($shippingMethodPricing2);

        $shippingMethodPricing3 = new ShippingMethodPricing(
            'Expresní doručení',
            ShippingMethod::get(ShippingMethod::DELIVERY_EXPRESS),
            Country::get(Country::CZECHIA),
            $money,
            $money,
            $money
        );
        $manager->persist($shippingMethodPricing3);

        $manager->flush();
    }
}
