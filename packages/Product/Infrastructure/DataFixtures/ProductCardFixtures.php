<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\CompatibleCar;
use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;

final class ProductCardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $frontCars = $this->frontCarsSetup();
        $backCars = $this->backCarsSetup();

        /**
         * @var Category $categoryColouredGlass
         */
        $categoryColouredGlass = $this->getReference('categoryColorGlass');

        /**
         * @var Category $categoryPureGlass
         */
        $categoryPureGlass = $this->getReference('categoryPureGlass');

        $productCardFront = new ProductCard(
            $categoryColouredGlass,
            'Čelní okno',
            VatRate::get(VatRate::BASE),
            Guarantee::get(Guarantee::TWO_YEARS)
        );
        $productCardFront->setOriginalCode('1111');

        $productCardBack = new ProductCard(
            $categoryPureGlass,
            'Zadní okno',
            VatRate::get(VatRate::BASE),
            Guarantee::get(Guarantee::TWO_YEARS)
        );
        $productCardBack->setOriginalCode('2222');

        $productCardFront->setDescription('S dešťovým senzorem');
        $productCardBack->setDescription('S dešťovým senzorem');

        foreach ($frontCars as $frontCar) {
            $compatibleFrontCardCar = new CompatibleCar(
                $productCardFront,
                $frontCar,
            );

            $productCardFront->addCompatibleCar($compatibleFrontCardCar);
            $manager->persist($compatibleFrontCardCar);
        }

        foreach ($backCars as $backCar) {
            $compatibleBackCardCar = new CompatibleCar(
                $productCardBack,
                $backCar,
            );

            $productCardBack->addCompatibleCar($compatibleBackCardCar);
            $manager->persist($compatibleBackCardCar);
        }

        $manager->persist($productCardFront);
        $manager->persist($productCardBack);

        $manager->flush();

        $this->addReference('productCardFront', $productCardFront);
        $this->addReference('productCardBack', $productCardBack);
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }

    /** @return array<int, CarInterface> */
    private function frontCarsSetup(): array
    {
        /** @var array<int, CarInterface> $carManufacturers */
        $carManufacturers = [
            $this->getReference('car0'),
            $this->getReference('car1'),
            $this->getReference('car2'),
            $this->getReference('car3'),
            $this->getReference('car4'),
        ];

        return $carManufacturers;
    }

    /** @return array<int, CarInterface> */
    private function backCarsSetup(): array
    {
        /** @var array<int, CarInterface> $carManufacturers */
        $carManufacturers = [
            $this->getReference('car5'),
            $this->getReference('car6'),
            $this->getReference('car7'),
            $this->getReference('car8'),
            $this->getReference('car9'),
        ];

        return $carManufacturers;
    }
}
