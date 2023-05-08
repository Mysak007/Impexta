<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientContactDetailsInterface extends EntityInterface
{
    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPhone(): string;

    public function setPhone(string $phone): void;
}
