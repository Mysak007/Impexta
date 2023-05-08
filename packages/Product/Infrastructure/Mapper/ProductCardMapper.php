<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Mapper;

use Impexta\Car\Domain\Factory\CompatibleCarFactory;
use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Infrastructure\Repository\CompatibleCarRepository;
use Impexta\Product\Presentation\Form\Model\ProductCardModel;

final class ProductCardMapper
{
    private CompatibleCarFactory $compatibleCarFactory;
    private CompatibleCarRepository $compatibleCarRepository;

    public function __construct(
        CompatibleCarFactory $compatibleCarFactory,
        CompatibleCarRepository $compatibleCarRepository
    ) {
        $this->compatibleCarFactory = $compatibleCarFactory;
        $this->compatibleCarRepository = $compatibleCarRepository;
    }

    public function mapFromModel(ProductCardModel $model, ProductCard $productCard): void
    {
        $productCard->setCategory($model->category);
        $productCard->setOriginalCode($model->originalCode);
        $productCard->setName($model->name);
        $productCard->setVatRate($model->vatRate);
        $productCard->setGuarantee($model->guarantee);
        $productCard->setDescription($model->description);
        $productCard->setNote($model->name);

        $entityCars = clone $productCard->getCompatibleCars();
        $modelCars = $model->cars;

        foreach ($modelCars as $modelCar) {
            $compatibleCar = $this->compatibleCarRepository->findOneBy(
                [
                    'productCard' => $productCard,
                    'car' => $modelCar,
                ]
            );

            if (!$compatibleCar) {
                $compatibleCar = $this->compatibleCarFactory->create($productCard, $modelCar);
                $this->compatibleCarRepository->save($compatibleCar);
            }

            $carToRemove = $entityCars->filter(static function ($entityCar) use ($compatibleCar) {
                return $compatibleCar->getId() === $entityCar->getCar()->getId();
            })->first();

            if ($carToRemove === false) {
                $productCard->addCompatibleCar($compatibleCar);

                continue;
            }

            $entityCars->removeElement($carToRemove);
        }

        foreach ($entityCars as $entityCar) {
            $productCard->removeCompatibleCar($entityCar);
            $this->compatibleCarRepository->remove($entityCar);
        }
    }
}
