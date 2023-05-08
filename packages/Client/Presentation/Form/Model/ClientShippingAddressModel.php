<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class ClientShippingAddressModel implements ModelInterface
{
    public ClientAddressModel $address;
    public ClientInterface $client;

    /** @param ClientShippingAddressInterface $clientShippingAddress */
    public static function createFromEntity(EntityInterface $clientShippingAddress): self
    {
        $model = new self();

        $model->address = ClientAddressModel::createFromEntity($clientShippingAddress->getAddress());
        $model->client = $clientShippingAddress->getClient();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
