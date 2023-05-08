<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Infrastructure\DataFixtures\AdminUserFixtures;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;

final class WarehouseOrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $warehouseOrders = [];
        /** @var AdminUserInterface $adminUser */
        $adminUser = $this->getReference('admin');

        for ($iteration = 0; $iteration <= 2; ++$iteration) {
            $warehouseOrder = new WarehouseOrder(
                Warehouse::get(Warehouse::PRAGUE),
                $adminUser
            );

            $warehouseOrder->setState(WarehouseOrderState::CREATED);

            $manager->persist($warehouseOrder);
            $warehouseOrders[] = $warehouseOrder;
        }

        $manager->flush();

        $iteration = 0;

        foreach ($warehouseOrders as $warehouseOrder) {
            $this->addReference('warehouseOrder' . $iteration, $warehouseOrder);
            ++$iteration;
        }
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            AdminUserFixtures::class,
        ];
    }
}
