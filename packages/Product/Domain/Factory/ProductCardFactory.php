<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Car\Domain\Factory\CompatibleCarFactory;
use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Impexta\Product\Presentation\Form\Model\ProductCardModel;

final class ProductCardFactory
{
    private CompatibleCarFactory $carFactory;

    public function __construct(CompatibleCarFactory $carFactory)
    {
        $this->carFactory = $carFactory;
    }

    public function create(ProductCardModel $model): ProductCardInterface
    {
        $productCard = new ProductCard(
            $model->category,
            $model->name,
            $model->vatRate,
            $model->guarantee
        );

        $productCard->setDescription($model->description);
        $productCard->setNote($model->note);
        $productCard->setOriginalCode($model->originalCode);

        $compatibleCars = $model->cars;

        foreach ($compatibleCars as $car) {
            $newCompatibleCar = $this->carFactory->create($productCard, $car);
            $productCard->addCompatibleCar($newCompatibleCar);
        }

        return $productCard;
    }
}
