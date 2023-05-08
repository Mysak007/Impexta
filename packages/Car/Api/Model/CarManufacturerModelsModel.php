<?php

declare(strict_types=1);

namespace Impexta\Car\Api\Model;

final class CarManufacturerModelsModel
{
    /** @var array<int, string> */
    public array $carModels;

    /**
     * @param array<int, string> $carModels
     */
    public function __construct(array $carModels)
    {
        $this->carModels = $carModels;
    }
}
