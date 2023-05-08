<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Infrastructure\DataFixtures\ClientFixtures;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Entity\OrderItem;
use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\DataFixtures\ProductFixtures;
use Impexta\Warehouse\Infrastructure\DataFixtures\WarehouseProductFixtures;
use Money\Currency;
use Money\Money;

final class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var OrderInterface $order */
        $order = $this->getReference('order');

        /**
         * @var Product $product
         */
        $product = $this->getReference('product0');

        for ($iteration = 0; $iteration <= 4; ++$iteration) {
            $money = new Money(random_int(199, 5999), new Currency('CZK'));
            $orderItem = new OrderItem(
                $order,
                $product,
                12,
                $money
            );

            $this->addReference('orderItem' . $iteration, $orderItem);
            $manager->persist($orderItem);
        }

        $manager->flush();
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            WarehouseProductFixtures::class,
            OrderFixtures::class,
            ProductFixtures::class,
        ];
    }
}
