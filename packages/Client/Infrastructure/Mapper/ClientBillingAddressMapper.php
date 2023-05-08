<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientBillingAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientBillingAddressModel;

final class ClientBillingAddressMapper
{
    public function mapFromModel(
        ClientBillingAddressModel $model,
        ClientBillingAddressInterface $clientBillingAddress
    ): void {
        $clientAddress = $clientBillingAddress->getAddress();
        $modelAddress = $model->address->address;

        $clientAddress->mapFromModel($modelAddress);
    }
}
