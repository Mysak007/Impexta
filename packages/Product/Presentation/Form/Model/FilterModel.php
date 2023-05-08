<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Impexta\Car\Domain\Entity\CarManufacturer;

final class FilterModel
{
    public ?CarManufacturer $manufacturer = null;
    public ?string $model = null;
    public ?int $yearOfManufacture = null;
    public ?float $engineCapacity = null;

    public static function createEmpty(): self
    {
        return new self();
    }
}
