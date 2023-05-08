<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Impexta\Car\Domain\Entity\CarInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface CompatibleCarInterface extends EntityInterface
{
    public function getProductCard(): ProductCard;

    public function getCar(): CarInterface;
}
