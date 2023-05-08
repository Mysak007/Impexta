<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientShippingAddress implements ClientShippingAddressInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientAddressInterface $address;
    private ClientInterface $client;

    public function __construct(
        ClientAddressInterface $address,
        ClientInterface $client
    ) {
        $this->address = $address;
        $this->client = $client;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAddress(): ClientAddressInterface
    {
        return $this->address;
    }

    public function setAddress(ClientAddressInterface $address): void
    {
        $this->address = $address;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function __toString(): string
    {
        return $this->address->getStreetAndBuildingNumber() . ', ' .
            ' ' . $this->address->getCity() . '' .
            ' ' . $this->address->getZipCode();
    }
}
