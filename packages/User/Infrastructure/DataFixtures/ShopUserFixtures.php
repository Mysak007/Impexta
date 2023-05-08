<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Infrastructure\DataFixtures\ClientFixtures;
use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Domain\Enum\UserRole;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ShopUserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var ClientInterface $client */
        $client = $this->getReference('client');

        $shopUser = new ShopUser(
            'client@example.com'
        );
        $shopUser->setClient($client);
        $shopUser->setEnabled(true);
        $shopUser->addRole(UserRole::get(UserRole::ROLE_CLIENT));
        $password = $this->passwordEncoder->encodePassword($shopUser, 'client');
        $shopUser->setPassword($password);

        $manager->persist($shopUser);
        $manager->flush();
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
        ];
    }
}
