<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Manager;

use Impexta\User\Domain\Entity\ShopUserInterface;
use Impexta\User\Presentation\Form\Model\ShopUserPasswordModel;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ShopUserPasswordManager
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function changeUserPassword(ShopUserInterface $user, ShopUserPasswordModel $shopUserPasswordModel): void
    {
        if (!$shopUserPasswordModel->password) {
            throw new InvalidArgumentException();
        }

        $password = $this->passwordEncoder->encodePassword($user, $shopUserPasswordModel->password);
        $user->setPassword($password);
        $user->setToken(null);
    }
}
