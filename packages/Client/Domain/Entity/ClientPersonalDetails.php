<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientPersonalDetails implements ClientPersonalDetailsInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ?string $taxId = null;
    private ?string $vatId = null;
    private ?string $vatIdSk = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $companyName = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTaxId(): ?string
    {
        return $this->taxId;
    }

    public function setTaxId(?string $taxId): void
    {
        $this->taxId = $taxId;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setVatId(?string $vatId): void
    {
        $this->vatId = $vatId;
    }

    public function getVatIdSk(): ?string
    {
        return $this->vatIdSk;
    }

    public function setVatIdSk(?string $vatIdSk): void
    {
        $this->vatIdSk = $vatIdSk;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getName(): string
    {
        if ($this->companyName) {
            return $this->companyName;
        }

        return $this->firstName . ' ' . $this->lastName;
    }
}
