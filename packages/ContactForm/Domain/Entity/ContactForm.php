<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ContactForm implements ContactFormInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;
    private string $email;
    private string $message;
    private ?string $vin;
    private ?string $phone;

    public function __construct(
        string $name,
        string $email,
        string $message
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(?string $vin): void
    {
        $this->vin = $vin;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
