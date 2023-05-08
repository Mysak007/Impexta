<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientBankAccount;
use Impexta\Client\Domain\Entity\ClientBankAccountInterface;
use Impexta\Client\Presentation\Form\Model\ClientBankAccountModel;

final class ClientBankAccountFactory
{
    public static function create(ClientBankAccountModel $model): ClientBankAccountInterface
    {
        return new ClientBankAccount(
            $model->bankName,
            $model->number
        );
    }
}
