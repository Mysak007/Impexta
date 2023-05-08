<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Car\Infrastructure\DataFixtures\CarFixtures;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientCar;

final class ClientCarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $cars = $this->setup();

        /**
         * @var Client $client
         */
        $client = $this->getReference('client');


        $iteration = 0;

        /**
         * @var Car $car
         */
        foreach ($cars as $car) {
            $clientCar = new ClientCar(
                $car,
                $client
            );

            $clientCar->setLicensePlate('A8E7519');
            $clientCar->setVin('TMBAEA200P0635724');
            $clientCar->setOwnerName('Client');

            $this->setReference('clientCar', $clientCar);
            $manager->persist($clientCar);
            $this->addReference('clientCar' . $iteration, $clientCar);
            ++$iteration;
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
            CarFixtures::class,
        ];
    }

    /** @return array<int, CarInterface> */
    private function setup(): array
    {
        /** @var array<int, CarInterface> $cars */
        $cars = [
            $this->getReference('car0'),
            $this->getReference('car1'),
            $this->getReference('car2'),
            $this->getReference('car3'),
            $this->getReference('car4'),
        ];

        return $cars;
    }
}
