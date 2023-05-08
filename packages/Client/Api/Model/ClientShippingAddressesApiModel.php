<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Model;

final class ClientShippingAddressesApiModel
{
    /** @var array<int, ClientShippingAddressApiModel> */
    public array $shippingAddresses = [];

    public function addShippingAddress(ClientShippingAddressApiModel $clientShippingAddressModel): void
    {
        $this->shippingAddresses[] = $clientShippingAddressModel;
    }
}
