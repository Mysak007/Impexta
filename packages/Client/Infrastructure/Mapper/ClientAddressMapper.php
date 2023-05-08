<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientAddress;
use Impexta\Client\Presentation\Form\Model\ClientAddressModel;

final class ClientAddressMapper
{
    public function mapFromModel(ClientAddressModel $clientAddressModel, ClientAddress $clientAddress): void
    {
        $clientAddress->setName($clientAddressModel->name);
        $clientAddress->mapFromModel($clientAddressModel->address);
    }
}
