<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\User\Domain\Enum\UserRole;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UserInterface extends EntityInterface, SymfonyUserInterface
{
    public function getPassword(): string;

    public function setPassword(string $password): void;

    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;

    /**
     * @return array<string> $roles
     */
    public function getRoles(): array;

    public function addRole(UserRole $role): void;

    public function getSalt(): ?string;

    public function eraseCredentials(): void;
}
