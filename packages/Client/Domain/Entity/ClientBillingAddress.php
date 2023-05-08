<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Impexta\Client\Presentation\Form\Model\ClientBillingAddressModel;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientBillingAddress implements ClientBillingAddressInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientAddressInterface $address;

    public function __construct(ClientAddressInterface $address)
    {
        $this->address = $address;
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

    public function mapFromModel(ClientBillingAddressModel $model): void
    {
        $modelAddress = $model->address->address;
        $this->address->mapFromModel($modelAddress);
    }

    public function __toString(): string
    {
        return $this->address->getStreetAndBuildingNumber() . ', ' .
            ' ' . $this->address->getCity() . '' .
            ' ' . $this->address->getZipCode();
    }
}
