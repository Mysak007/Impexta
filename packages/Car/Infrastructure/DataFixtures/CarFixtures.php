<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Car\Domain\Entity\CarManufacturer;
use Impexta\Car\Domain\Entity\CarManufacturerInterface;
use Impexta\Car\Domain\Enum\CarCategory;

final class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $carManufacturers = $this->setup();

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

        $iteration = 0;
        $cars = [];

        /**
         * @var CarManufacturer $carManufacturer
         */
        foreach ($carManufacturers as $carManufacturer) {
            $car = new Car(
                $carManufacturer,
                CarCategory::get(CarCategory::PERSONAL),
                $models[$iteration],
                random_int(2000, 2020),
                2.0,
                true
            );
            ++$iteration;

            $manager->persist($car);

            $cars[] = $car;
        }

        $manager->flush();

        $iterationCar = '0';

        /**
         * @var CarInterface $car
         */
        foreach ($cars as $car) {
            $this->addReference('car' . +$iterationCar, $car);
            ++$iterationCar;
        }
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            CarManufacturerFixtures::class,
        ];
    }

    /** @return array<int, CarManufacturerInterface> */
    private function setup(): array
    {
        /** @var array<int, CarManufacturerInterface> $carManufacturers */
        $carManufacturers = [
            $this->getReference('carManufacturer0'),
            $this->getReference('carManufacturer1'),
            $this->getReference('carManufacturer2'),
            $this->getReference('carManufacturer3'),
            $this->getReference('carManufacturer4'),
            $this->getReference('carManufacturer5'),
            $this->getReference('carManufacturer6'),
            $this->getReference('carManufacturer7'),
            $this->getReference('carManufacturer8'),
            $this->getReference('carManufacturer9'),
        ];

        return $carManufacturers;
    }
}
