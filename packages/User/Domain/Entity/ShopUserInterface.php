<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\Client\Domain\Entity\ClientInterface;
use Ramsey\Uuid\UuidInterface;

interface ShopUserInterface extends UserInterface
{
    public function getEmail(): string;

    public function getClient(): ?ClientInterface;

    public function setClient(?ClientInterface $client): void;

    public function getUsername(): string;

    public function getToken(): ?UuidInterface;

    public function setToken(?UuidInterface $token): void;

    public function refreshToken(): void;
}
