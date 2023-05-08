<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Model;

final class ClientCarsModel
{
    /** @var array<int, ClientCarModel> */
    public array $cars = [];

    public function addCar(ClientCarModel $car): void
    {
        $this->cars[] = $car;
    }
}
