<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Order\Domain\Entity\OrderItemInterface;
use Impexta\Order\Domain\Entity\OrderItemProductDetails;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;

final class OrderItemProductDetailsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->getReference('orderItem0');

        $orderItemProductDetails = new OrderItemProductDetails(
            $orderItem,
            VatRate::get(VatRate::BASE),
            Guarantee::get(Guarantee::TWO_YEARS),
            '123456789',
            'Okno',
            'Jeep',
            2
        );

        $this->addReference('orderItemProductDetails', $orderItemProductDetails);
        $manager->persist($orderItem);
        $manager->flush();
    }

    /** @return array<class-string<Fixture>> */
    public function getDependencies(): array
    {
        return [
            OrderItemFixtures::class,
        ];
    }
}
