<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientShippingAddressInterface extends EntityInterface
{
    public function getAddress(): ClientAddressInterface;

    public function setAddress(ClientAddressInterface $address): void;

    public function getClient(): ClientInterface;

    public function setClient(Client $client): void;
}
