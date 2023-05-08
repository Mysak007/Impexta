<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\DataFixtures\ProductFixtures;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItem;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;

final class WarehouseOrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var ArrayCollection<int, WarehouseOrderInterface> $warehouseOrders */
        $warehouseOrders = new ArrayCollection();

        for ($iteration = 0; $iteration <= 2; ++$iteration) {
            /** @var WarehouseOrderInterface $warehouseorder */
            $warehouseorder = $this->getReference('warehouseOrder' . $iteration);
            $warehouseOrders->add($warehouseorder);
        }

        /** @var ArrayCollection<int, ProductInterface> $products */
        $products = new ArrayCollection();

        for ($iteration = 0; $iteration <= 9; ++$iteration) {
            /** @var ProductInterface $product */
            $product = $this->getReference('product' . $iteration);
            $products->add($product);
        }

        $productsPerWarehouseOrder = $products->count() / $warehouseOrders->count();

        $cycle = 0;

        foreach ($products as $product) {
            /** @var WarehouseOrderInterface $warehouseorder */
            $warehouseorder = $warehouseOrders->get((int)floor($cycle / $productsPerWarehouseOrder));

            $warehouseOrderItem = new WarehouseOrderItem(
                $warehouseorder,
                $product,
                random_int(1, 10),
                'dodavatel' . random_int(1, 10),
            );

            $warehouseOrderItem->setState(WarehouseOrderState::CREATED);
            $manager->persist($warehouseOrderItem);

            ++$cycle;
        }

        $manager->flush();
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            WarehouseOrderFixtures::class,
        ];
    }
}
