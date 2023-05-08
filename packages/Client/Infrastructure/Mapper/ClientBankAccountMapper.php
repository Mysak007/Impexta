<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientBankAccountInterface;
use Impexta\Client\Presentation\Form\Model\ClientBankAccountModel;

final class ClientBankAccountMapper
{
    public function mapFromModel(ClientBankAccountModel $model, ClientBankAccountInterface $clientBankAccount): void
    {
        $clientBankAccount->setBankName($model->bankName);
        $clientBankAccount->setNumber($model->number);
    }
}
