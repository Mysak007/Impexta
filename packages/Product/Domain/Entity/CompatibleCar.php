<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Impexta\Car\Domain\Entity\CarInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class CompatibleCar implements CompatibleCarInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ProductCard $productCard;
    private CarInterface $car;

    public function __construct(
        ProductCard $productCard,
        CarInterface $car
    ) {
        $this->productCard = $productCard;
        $this->car = $car;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductCard(): ProductCard
    {
        return $this->productCard;
    }

    public function getCar(): CarInterface
    {
        return $this->car;
    }
}
