<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Mapper;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Domain\Entity\SecondHandProductImageInterface;
use Impexta\Product\Domain\Factory\SecondHandProductImageFactory;
use Impexta\Product\Infrastructure\Repository\SecondHandProductImageRepository;
use Impexta\Product\Presentation\Form\Model\SecondHandProductModel;

final class SecondHandProductMapper
{
    private SecondHandProductImageFactory $imageFactory;
    private SecondHandProductImageRepository $imageRepository;

    public function __construct(
        SecondHandProductImageFactory $imageFactory,
        SecondHandProductImageRepository $imageRepository
    ) {
        $this->imageFactory = $imageFactory;
        $this->imageRepository = $imageRepository;
    }

    public function mapFromModel(SecondHandProductModel $model, SecondHandProduct $product): void
    {
        $product->setName($model->name);
        $product->setPerex($model->perex);
        $product->setDescription($model->description);
        $product->setPrice($model->price);
        $product->setVatRate($model->vatRate);

        $modelImages = $model->images;

        foreach ($modelImages as $key => $image) {
            // New images
            if (!$image->filename && $image->file) {
                $newImage = $this->imageFactory->create($product, $image);
                $product->addSecondHandProductImage($newImage);

                continue;
            }

            /** @var SecondHandProductImageInterface|null $secondHandProductImage */
            $secondHandProductImage = $product->getSecondHandProductImages()->get($key);

            // User created new image entity but did not upload any file
            if (!$secondHandProductImage) {
                continue;
            }

            // Images to delete
            if (!$image->filename && !$image->file) {
                $product->removeSecondHandProductImage($secondHandProductImage);
                $this->imageRepository->remove($secondHandProductImage);

                continue;
            }

            // Existing images we want to keep
            $secondHandProductImage->setIsMain($image->isMain);
        }
    }
}
