<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Entity;

use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\User\Presentation\Form\Model\ShopUserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ShopUser extends AbstractUser implements ShopUserInterface
{
    private int $id;
    private string $email;
    private ?ClientInterface $client = null;
    private ?UuidInterface $token = null;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    public function setClient(?ClientInterface $client): void
    {
        $this->client = $client;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getToken(): ?UuidInterface
    {
        return $this->token;
    }

    public function setToken(?UuidInterface $token): void
    {
        $this->token = $token;
    }

    public function refreshToken(): void
    {
        $this->setToken(Uuid::uuid4());
    }

    public function mapFromShopUserModel(ShopUserModel $model): void
    {
        if ($model->password->password) {
            $this->setPassword($model->password->password);
        }

        $this->setEnabled($model->enabled);
        $this->setClient($model->client);
    }
}
