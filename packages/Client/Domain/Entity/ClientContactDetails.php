<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientContactDetails implements ClientContactDetailsInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $email;
    private string $phone;

    public function __construct(
        string $email,
        string $phone
    ) {
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
