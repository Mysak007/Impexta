<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Shipping\Domain\Entity\Shipment;
use Impexta\Shipping\Domain\Enum\ShipmentState;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Money\Currency;
use Money\Money;

final class ShipmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $price = new Money(4999, new Currency('CZK'));

        $shipment = new Shipment(
            ShipmentState::get(ShipmentState::NEW),
            ShippingMethod::get(ShippingMethod::DELIVERY),
            $price
        );

        $shipment->setTrackingCode('123456789');
        $this->addReference('shipment', $shipment);

        $manager->persist($shipment);
        $manager->flush();
    }
}
