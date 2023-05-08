<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Model;

final class ClientShippingAddressApiModel
{
    public int $id;
    public string $street;
    public string $houseNumber;
    public string $city;
    public string $zipCode;

    public function __construct(
        int $id
    ) {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return sprintf('%s %s, %s %s', $this->street, $this->houseNumber, $this->city, $this->zipCode);
    }
}
