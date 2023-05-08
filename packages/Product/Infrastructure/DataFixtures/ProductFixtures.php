<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Domain\Entity\ProductPrice;
use Money\Currency;
use Money\Money;

final class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /**
         * @var array<int, ProductCard> $productCards
         */
        $productCards = [
            $this->getReference('productCardFront'),
            $this->getReference('productCardBack'),
        ];

        $manufacturers = [
            'Buick',
            'Tesla',
            'Ford',
            'GMC',
            'SSC',
            'Jeep',
            'Chrysler',
            'Cadillac',
            'Corvette',
            'Lincoln',
        ];

        $models = [
            'LeSabre',
            'Cybertruck',
            'Mustang',
            'Sierra 1500',
            'Tuatara',
            'Wrangler',
            '300C',
            'Escalade',
            'Corvette C6',
            'Continental',
        ];

        $products = [];

        for ($iteration = 0; $iteration <= 9; ++$iteration) {
            $name = 'Čelní okno ' . $manufacturers[$iteration] . ' ' . $models[$iteration];
            shuffle($productCards);

            $product = new Product(
                $productCards[0],
                (string)random_int(90000, 99999),
                $name,
                'celni-okno-volvo',
                $manufacturers[$iteration],
                random_int(10, 20),
                true,
                false,
                true
            );

            $clientGroups = [
                ClientGroup::get(ClientGroup::B2C),
                ClientGroup::get(ClientGroup::B2B),
            ];

            foreach ($clientGroups as $clientGroup) {
                $price = new Money(random_int(49999, 499999), new Currency('CZK'));
                $productPrice = new ProductPrice(
                    $product,
                    $price
                );
                $productPrice->setClientGroup($clientGroup);
                $product->addPrice($productPrice);
                $eurPrice = new Money(random_int(49999, 499999), new Currency('EUR'));
                $eurProductPrice = new ProductPrice(
                    $product,
                    $eurPrice
                );
                $eurProductPrice->setClientGroup($clientGroup);
                $product->addPrice($eurProductPrice);
            }

            $manager->persist($product);
            $products[] = $product;
        }

        $manager->flush();

        $iteration = '0';

        foreach ($products as $product) {
            $this->addReference('product' . $iteration, $product);
            ++$iteration;
        }
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ProductCardFixtures::class,
        ];
    }
}
