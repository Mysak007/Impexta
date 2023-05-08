<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Money\Currency;

final class ClientFactory
{
    private ClientBillingAddressFactory $billingAddressFactory;
    private ClientShippingAddressFactory $shippingAddressFactory;

    public function __construct(
        ClientBillingAddressFactory $billingAddressFactory,
        ClientShippingAddressFactory $shippingAddressFactory
    ) {
        $this->billingAddressFactory = $billingAddressFactory;
        $this->shippingAddressFactory = $shippingAddressFactory;
    }

    public function createClient(ClientModel $model): ClientInterface
    {
        $client = new Client(
            ClientPersonalDetailsFactory::createFromModel($model->personalDetails),
            ClientContactDetailsFactory::create($model->contactDetails),
            $this->billingAddressFactory->create($model->billingAddress),
            $model->clientGroup,
            new Currency($model->currency),
            $model->country,
            $model->sale,
        );

        $modelShippingAddress = $model->shippingAddress;

        if (count((array)$model->shippingAddress) > 0 && $modelShippingAddress) {
            $newShippingAddress = $this->shippingAddressFactory->create($modelShippingAddress, $client);
            $client->addShippingAddress($newShippingAddress);
        }

        if ($model->bankAccount) {
            $client->setBankAccount(ClientBankAccountFactory::create($model->bankAccount));
        }

        if ($model->logo) {
            $client->setLogo($model->logo);
        }

        $client->setNote($model->note);

        foreach ($model->clientCars as $clientCar) {
            $client->addCar(ClientCarFactory::create($clientCar, $client));
        }

        return $client;
    }
}
