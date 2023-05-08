<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientBillingAddressInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class ClientBillingAddressModel implements ModelInterface
{
    public ClientAddressModel $address;

    /** @param ClientBillingAddressInterface $clientBillingAddress */
    public static function createFromEntity(EntityInterface $clientBillingAddress): self
    {
        $model = new self();

        $model->address = ClientAddressModel::createFromEntity($clientBillingAddress->getAddress());

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
