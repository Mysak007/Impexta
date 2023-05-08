<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;

final class ClientShippingAddressMapper
{
    public function mapFromModel(
        ClientShippingAddressModel $model,
        ClientShippingAddressInterface $clientShippingAddress
    ): void {
        $clientAddress = $clientShippingAddress->getAddress();
        $modelAddress = $model->address;

        $clientAddress->setName($modelAddress->name);
        $clientAddress->mapFromModel($modelAddress->address);
    }
}
