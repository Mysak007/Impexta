<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Order\Domain\Entity\OnlinePayment;

final class OnlinePaymentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $onlinePayment = new OnlinePayment(
            '123'
        );

        $this->addReference('onlinePayment', $onlinePayment);
        $manager->persist($onlinePayment);
        $manager->flush();
    }
}
