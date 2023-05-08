<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Factory;

use Impexta\Client\Api\Model\ClientShippingAddressApiModel;
use Impexta\Client\Api\Model\ClientShippingAddressesApiModel;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;

final class ClientShippingAddressesApiModelFactory
{
    public function create(ClientInterface $client): ClientShippingAddressesApiModel
    {
        $clientShippingAddressesModel = new ClientShippingAddressesApiModel();

        /** @var ClientShippingAddressInterface $shippingAddress */
        foreach ($client->getShippingAddresses() as $shippingAddress) {
            $clientShippingAddress = new ClientShippingAddressApiModel($shippingAddress->getId());
            $clientShippingAddress->street = $shippingAddress->getAddress()->getStreet();
            $clientShippingAddress->houseNumber = $shippingAddress->getAddress()->getHouseNumber();
            $clientShippingAddress->city = $shippingAddress->getAddress()->getCity();
            $clientShippingAddress->zipCode = $shippingAddress->getAddress()->getZipCode();
            $clientShippingAddressesModel->addShippingAddress(
                $clientShippingAddress
            );
        }

        return $clientShippingAddressesModel;
    }
}
