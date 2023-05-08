<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\DataFixtures;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Infrastructure\DataFixtures\ClientFixtures;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Enum\InquiryOrigin;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Infrastructure\DataFixtures\AdminUserFixtures;

final class InquiryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($iteration = 0; $iteration <= 4; ++$iteration) {
            /** @var ClientInterface $client */
            $client = $this->getReference('client');
            $dateNow = new DateTimeImmutable('NOW');
            $futureDate = new DateTimeImmutable('NOW');
            $inquiry = new Inquiry(
                InquiryOrigin::get(InquiryOrigin::PHONE),
                $dateNow,
                $futureDate,
                $client,
                5,
            );
            /** @var AdminUserInterface $superAdmin */
            $superAdmin = $this->getReference('superadmin');
            $inquiry->setAssignee($superAdmin);
            $manager->persist($inquiry);
            $this->addReference('inquiry' . $iteration, $inquiry);
        }

        $manager->flush();
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            AdminUserFixtures::class,
        ];
    }
}
