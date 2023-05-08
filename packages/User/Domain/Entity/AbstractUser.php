<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\User\Domain\Enum\UserRole;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

abstract class AbstractUser implements UserInterface
{
    use TimestampableEntityTrait;

    private string $password;
    private bool $enabled = false;

    /** @var array<string> $roles */
    private array $roles = [];

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function addRole(UserRole $role): void
    {
        $this->roles = array_unique(array_merge($this->roles, [$role->getValue()]));
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        //see UserInterface
    }
}
