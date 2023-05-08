<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientBankAccountInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Enum\Bank;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientBankAccountModel implements ModelInterface
{
    /** @Assert\Length(max=255) */
    public Bank $bankName;

    /** @Assert\Length(max=255) */
    public string $number;

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }

    /**
     * @param ClientBankAccountInterface $clientBankAccount
     */
    public static function createFromEntity(EntityInterface $clientBankAccount): self
    {
        $model = new self();

        $model->bankName = $clientBankAccount->getBankName();
        $model->number = $clientBankAccount->getNumber();

        return $model;
    }
}
