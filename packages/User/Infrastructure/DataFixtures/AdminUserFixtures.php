<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Enum\UserRole;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class AdminUserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $superAdmin = new AdminUser('superadmin');
        $password = $this->passwordEncoder->encodePassword($superAdmin, 'superadmin');
        $superAdmin->setPassword($password);
        $superAdmin->addRole(UserRole::get(UserRole::ROLE_SUPERADMIN));
        $superAdmin->setEnabled(true);
        $superAdmin->setName('Super');
        $superAdmin->setSurname('Admin');

        $admin = new AdminUser('admin');
        $password = $this->passwordEncoder->encodePassword($superAdmin, 'admin');
        $admin->setPassword($password);
        $admin->addRole(UserRole::get(UserRole::ROLE_ADMIN));
        $admin->setEnabled(true);
        $admin->setName('Regular');
        $admin->setSurname('Admin');

        $manager->persist($superAdmin);
        $manager->persist($admin);
        $this->addReference('admin', $admin);
        $this->addReference('superadmin', $superAdmin);

        $manager->flush();
    }
}
