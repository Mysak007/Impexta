<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Factory;

use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ShopUserFactory
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(ShopUserModel $shopUserModel): ShopUserInterface
    {
        if (!$shopUserModel->password->password) {
            throw new InvalidArgumentException();
        }

        $shopUser = new ShopUser($shopUserModel->email);
        /** @var string $modelPassword */
        $modelPassword = $shopUserModel->password->password;
        $password = $this->passwordEncoder->encodePassword($shopUser, $modelPassword);
        $shopUser->setPassword($password);
        $shopUser->addRole(UserRole::get(UserRole::ROLE_CLIENT));
        $shopUser->setToken(Uuid::uuid4());
        $shopUser->setEnabled($shopUserModel->enabled);
        $shopUser->setClient($shopUserModel->client);

        return $shopUser;
    }
}
