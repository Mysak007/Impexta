<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Factory;

use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Product\Domain\Entity\CompatibleCar;
use Impexta\Product\Domain\Entity\ProductCard;

final class CompatibleCarFactory
{
    public function create(ProductCard $productCard, CarInterface $car): CompatibleCar
    {
        return new CompatibleCar(
            $productCard,
            $car
        );
    }
}
