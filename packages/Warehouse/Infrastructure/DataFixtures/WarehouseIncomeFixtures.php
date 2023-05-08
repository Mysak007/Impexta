<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Warehouse\Domain\Entity\WarehouseIncome;
use Impexta\Warehouse\Domain\Enum\Warehouse;

final class WarehouseIncomeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable();

        $warehouseIncome = new WarehouseIncome(
            '12',
            Warehouse::get(Warehouse::PRAGUE),
            '567',
            $date
        );

        $manager->persist($warehouseIncome);
        $manager->flush();

        $this->addReference('warehouseIncome', $warehouseIncome);
    }
}
