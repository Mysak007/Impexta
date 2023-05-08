<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Entity\StoreAddress;
use Impexta\Store\Domain\Entity\StoreContactInformation;
use Impexta\Store\Domain\Entity\StoreOpeningHours;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;

final class StoreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $storeAddresses = [];
        $contactInformations = [];

        for ($index = 0; $index < 3; ++$index) {
            $storeAddress = new StoreAddress();

            $storeAddress->setCode('123456');
            $storeAddress->setLatitude('50.04024057348884');
            $storeAddress->setLongitude('15.769529871252942');
            $storeAddress->setStreet('Sukova třída');
            $storeAddress->setHouseNumber('1735');
            $storeAddress->setCity('Pardubice');
            $storeAddress->setZipCode('53002');
            $storeAddress->setDistrict('Zelené Předměstí');
            $storeAddress->setRegion('Pardubický kraj');
            $storeAddress->setCountry('Česká Republika');

            $storeAddresses[] = $storeAddress;

            $storeContactInformation = new StoreContactInformation();

            $storeContactInformation->setEmail('store@example.com');
            $storeContactInformation->setPhone('+420123456789');

            $contactInformations[] = $storeContactInformation;
        }

        for ($index = 0; $index < 3; ++$index) {
            $store = new Store(
                'Client\'s store',
                $storeAddresses[$index],
                $contactInformations[$index]
            );

            $manager->persist($store);

            for ($hourIndex = 1; $hourIndex < 8; ++$hourIndex) {
                $opensAtHour = random_int(8, 12);
                $opensAt = new DateTimeImmutable();
                $opensAt = $opensAt->setTime($opensAtHour, 0);

                $closesAtHour = random_int(13, 20);
                $closesAt = new DateTimeImmutable();
                $closesAt = $closesAt->setTime($closesAtHour, 0);

                $storeOpeningHours = new StoreOpeningHours(
                    $store,
                    $hourIndex,
                    true
                );

                $storeOpeningHours->setOpensAt($opensAt);
                $storeOpeningHours->setClosesAt($closesAt);

                $store->addOpeningHour($storeOpeningHours);
            }

            for ($specialHourIndex = 1; $specialHourIndex < 8; ++$specialHourIndex) {
                $day = new DateTimeImmutable('2021-0' . $specialHourIndex . '-26');

                $opensAtHour = random_int(8, 12);
                $opensAt = new DateTimeImmutable();
                $opensAt = $opensAt->setTime($opensAtHour, 0, 0, 0);

                $closesAtHour = random_int(13, 20);
                $closesAt = new DateTimeImmutable();
                $closesAt = $closesAt->setTime($closesAtHour, 0, 0, 0);

                $storeSpecialOpeningHours = new StoreSpecialOpeningHours(
                    $store,
                    $day,
                    true
                );

                $storeSpecialOpeningHours->setOpensAt($opensAt);
                $storeSpecialOpeningHours->setClosesAt($closesAt);

                $store->addSpecialOpeningHour($storeSpecialOpeningHours);
            }
        }

        $manager->flush();
    }
}
