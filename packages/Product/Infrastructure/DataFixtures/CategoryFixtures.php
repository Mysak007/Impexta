<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Product\Domain\Entity\Category;

final class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryGlass = new Category(
            'Autoskla',
            'autoskla'
        );

        $categoryColouredGlass = new Category(
            'Barvená autoskla',
            'barvena-autoskla'
        );

        $categoryPureGlass = new Category(
            'Čirá autoskla',
            'cira-autoskla'
        );

        $categoryColouredGlass->setParent($categoryGlass);
        $categoryPureGlass->setParent($categoryGlass);

        $manager->persist($categoryGlass);
        $manager->persist($categoryColouredGlass);
        $manager->persist($categoryPureGlass);
        $manager->flush();

        $this->addReference('categoryColorGlass', $categoryColouredGlass);
        $this->addReference('categoryPureGlass', $categoryPureGlass);
    }
}
