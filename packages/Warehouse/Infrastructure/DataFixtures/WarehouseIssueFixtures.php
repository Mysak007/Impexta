<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Infrastructure\DataFixtures\AdminUserFixtures;
use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;

final class WarehouseIssueFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable();
        /** @var AdminUserInterface $adminUser */
        $adminUser = $this->getReference('admin');
        $warehouseIssue = new WarehouseIssue(
            '123',
            Warehouse::get(Warehouse::PRAGUE),
            $adminUser,
            '456',
            $date
        );

        /** @var WarehouseProductInterface $warehouseProduct */
        $warehouseProduct = $this->getReference('warehouseProduct0');
        $warehouseIssue->addWarehouseProduct($warehouseProduct);

        $manager->persist($warehouseIssue);
        $manager->flush();

        $this->addReference('warehouseIssue', $warehouseIssue);
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            AdminUserFixtures::class,
            WarehouseProductFixtures::class,
        ];
    }
}
