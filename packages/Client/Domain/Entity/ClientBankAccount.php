<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Microshop\SymfonySurvivalKit\Enum\Bank;

class ClientBankAccount implements ClientBankAccountInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private Bank $bank;
    private string $number;

    public function __construct(
        Bank $bank,
        string $number
    ) {
        $this->bank = $bank;
        $this->number = $number;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBankName(): Bank
    {
        return $this->bank;
    }

    public function setBankName(Bank $bank): void
    {
        $this->bank = $bank;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getBankCode(): string
    {
        /** @var string $bankCode */
        $bankCode = $this->bank->getValue();

        return $bankCode;
    }
}
