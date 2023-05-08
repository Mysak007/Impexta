<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Model;

final class ClientCarModel
{
    public int $id;
    public string $manufacturer;
    public string $model;
    public int $yearOfManufacture;
    public ?string $licensePlate;

    public function __construct(
        int $id,
        string $manufacturer,
        string $model,
        int $yearOfManufacture,
        ?string $licensePlate
    ) {
        $this->id = $id;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->yearOfManufacture = $yearOfManufacture;
        $this->licensePlate = $licensePlate;
    }
}
