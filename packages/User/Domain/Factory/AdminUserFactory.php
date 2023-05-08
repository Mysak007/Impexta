<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Factory;

use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Presentation\Form\Model\AdminUserModel;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class AdminUserFactory
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(AdminUserModel $adminUserModel): AdminUserInterface
    {
        if (!$adminUserModel->password) {
            throw new InvalidArgumentException();
        }

        $adminUser = new AdminUser($adminUserModel->username);
        $password = $this->passwordEncoder->encodePassword($adminUser, $adminUserModel->password);
        $adminUser->setPassword($password);
        $adminUser->setEnabled($adminUserModel->enabled);
        $adminUser->addRole(UserRole::get(UserRole::ROLE_ADMIN));
        $adminUser->setName($adminUserModel->name);
        $adminUser->setSurname($adminUserModel->surname);

        return $adminUser;
    }
}
