<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\DataFixtures\ProductFixtures;
use Impexta\Warehouse\Domain\Entity\WarehouseProduct;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Money\Currency;
use Money\Money;

final class WarehouseProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $products = $this->setup();
        $purchasePrice = new Money(6780, new Currency('CZK'));

        for ($iteration = 0; $iteration <= 4; ++$iteration) {
            /**
             * @var Product $product
             */
            foreach ($products as $product) {
                $warehouseProduct = new WarehouseProduct(
                    $product,
                    Warehouse::get(Warehouse::PRAGUE),
                    $purchasePrice
                );

                $manager->persist($warehouseProduct);
                $this->addReference('warehouseProduct' . $iteration, $warehouseProduct);
                ++$iteration;
            }
        }

        $manager->flush();
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }

    /** @return array<int, ProductInterface> */
    private function setup(): array
    {
        /** @var array<int, ProductInterface> $products */
        $products = [
            $this->getReference('product0'),
            $this->getReference('product1'),
            $this->getReference('product2'),
            $this->getReference('product3'),
            $this->getReference('product4'),
        ];

        return $products;
    }
}
