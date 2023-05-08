<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientPersonalDetailsInterface extends EntityInterface
{
    public function getTaxId(): ?string;

    public function setTaxId(?string $taxId): void;

    public function getVatId(): ?string;

    public function setVatId(?string $vatId): void;

    public function getVatIdSk(): ?string;

    public function setVatIdSk(?string $vatIdSk): void;

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getCompanyName(): ?string;

    public function setCompanyName(?string $companyName): void;

    public function getName(): string;
}
