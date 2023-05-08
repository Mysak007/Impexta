<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\User\Domain\Enum\UserRole;

interface AdminUserInterface extends UserInterface
{
    public function getUsername(): string;

    public function hasRole(UserRole $role): bool;

    public function getName(): string;

    public function setName(string $name): void;

    public function getSurname(): string;

    public function setSurname(string $surname): void;

    public function __toString(): string;
}
