<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Factory\ClientBankAccountFactory;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Money\Currency;

final class ClientMapper
{
    private ClientPersonalDetailsMapper $personalDetailsMapper;
    private ClientContactDetailsMapper $contactDetailsMapper;
    private ClientBillingAddressMapper $billingAddressMapper;
    private ClientBankAccountMapper $clientBankAccountMapper;
    private ClientCarsMapper $clientCarsMapper;
    private ClientShippingAddressMapper $shippingAddressMapper;

    public function __construct(
        ClientPersonalDetailsMapper $personalDetailsMapper,
        ClientContactDetailsMapper $contactDetailsMapper,
        ClientBillingAddressMapper $billingAddressMapper,
        ClientBankAccountMapper $clientBankAccountMapper,
        ClientCarsMapper $clientCarsMapper,
        ClientShippingAddressMapper $shippingAddressMapper
    ) {
        $this->personalDetailsMapper = $personalDetailsMapper;
        $this->contactDetailsMapper = $contactDetailsMapper;
        $this->billingAddressMapper = $billingAddressMapper;
        $this->clientBankAccountMapper = $clientBankAccountMapper;
        $this->shippingAddressMapper = $shippingAddressMapper;
        $this->clientCarsMapper = $clientCarsMapper;
    }

    public function mapFromModel(ClientModel $model, Client $client): void
    {
        $this->personalDetailsMapper->mapFromModel($model->personalDetails, $client->getPersonalDetails());
        $this->contactDetailsMapper->mapFromModel($model->contactDetails, $client->getContactDetails());
        $this->billingAddressMapper->mapFromModel($model->billingAddress, $client->getBillingAddress());
        $client->setClientGroup($model->clientGroup);
        $client->setCurrency(new Currency($model->currency));
        $client->setSale($model->sale);

        $shippingAddressModel = $model->shippingAddress;
        $clientBankAccountModel = $model->bankAccount;
        $clientBankAccount = $client->getBankAccount();

        $defaultShippingAddress = $client->getDefaultShippingAddress();

        if ($shippingAddressModel && $defaultShippingAddress) {
            $this->shippingAddressMapper->mapFromModel($shippingAddressModel, $defaultShippingAddress);
        }

        if ($clientBankAccountModel) {
            if (!$clientBankAccount) {
                $bankAccount = ClientBankAccountFactory::create($clientBankAccountModel);
                $client->setBankAccount($bankAccount);

                return;
            }

            $this->clientBankAccountMapper->mapFromModel($clientBankAccountModel, $clientBankAccount);
        }

        $client->setNote($model->note);
        $this->clientCarsMapper->mapFromModel($client, $model);
    }
}
