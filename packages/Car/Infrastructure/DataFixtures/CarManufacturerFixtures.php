<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Car\Domain\Entity\CarManufacturer;

final class CarManufacturerFixtures extends Fixture
{
    private const MANUFACTURERS = [
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

    public function load(ObjectManager $manager): void
    {
        $iteration = '0';

        foreach (self::MANUFACTURERS as $manufacturer) {
            $carManufacturer = new CarManufacturer(
                $manufacturer,
                true
            );
            $manager->persist($carManufacturer);

            $this->addReference('carManufacturer' . $iteration, $carManufacturer);
            ++$iteration;
        }

        $manager->flush();
    }
}
