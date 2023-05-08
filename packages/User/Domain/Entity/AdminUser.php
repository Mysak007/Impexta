<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\User\Domain\Enum\UserRole;
use Impexta\User\Presentation\Form\Model\AdminUserModel;

class AdminUser extends AbstractUser implements AdminUserInterface
{
    private int $id;
    private string $username;
    private string $name;
    private string $surname;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function hasRole(UserRole $role): bool
    {
        $roles = $this->getRoles();

        return in_array($role->getValue(), $roles, true);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function mapFromAdminUserModel(AdminUserModel $model): void
    {
        if ($model->password) {
            $this->setPassword($model->password);
        }

        $this->setEnabled($model->enabled);
        $this->name = $model->name;
        $this->surname = $model->surname;
    }

    public function __toString(): string
    {
        if ($this->name && $this->surname) {
            return $this->getName() . ' ' . $this->getSurname();
        }

        return $this->getUsername();
    }
}
