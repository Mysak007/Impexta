<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientShippingAddressModel;

final class ClientShippingAddressFactory
{
    private ClientAddressFactory $clientAddressFactory;

    public function __construct(
        ClientAddressFactory $clientAddressFactory
    ) {
        $this->clientAddressFactory = $clientAddressFactory;
    }

    public function create(
        ClientShippingAddressModel $clientAddress,
        ClientInterface $client
    ): ClientShippingAddressInterface {
        $newClientAddress = $this->clientAddressFactory->create($clientAddress->address);

        return new ClientShippingAddress(
            $newClientAddress,
            $client
        );
    }
}
