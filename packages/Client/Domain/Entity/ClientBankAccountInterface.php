<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Enum\Bank;

interface ClientBankAccountInterface extends EntityInterface
{
    public function getBankName(): Bank;

    public function setBankName(Bank $bank): void;

    public function getNumber(): string;

    public function setNumber(string $number): void;

    public function getBankCode(): string;
}
