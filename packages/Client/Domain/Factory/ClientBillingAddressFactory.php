<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientBillingAddress;
use Impexta\Client\Domain\Entity\ClientBillingAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientBillingAddressModel;

final class ClientBillingAddressFactory
{
    private ClientAddressFactory $clientAddressFactory;

    public function __construct(
        ClientAddressFactory $clientAddressFactory
    ) {
        $this->clientAddressFactory = $clientAddressFactory;
    }

    public function create(ClientBillingAddressModel $clientAddress): ClientBillingAddressInterface
    {
        $newClientAddress = $this->clientAddressFactory->create($clientAddress->address);

        return new ClientBillingAddress(
            $newClientAddress
        );
    }
}
