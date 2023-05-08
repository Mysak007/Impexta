<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ContactFormInterface extends EntityInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getMessage(): string;

    public function setMessage(string $message): void;

    public function getVin(): ?string;

    public function setVin(?string $vin): void;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): void;
}
