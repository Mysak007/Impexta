<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\ProductImage;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Presentation\Form\Model\ProductImageModel;

final class ProductImageFactory
{
    public function create(
        ProductInterface $product,
        ProductImageModel $imageModel
    ): ProductImage {
        $productImage = new ProductImage(
            $product,
            $imageModel->isMain
        );

        $productImage->setFile($imageModel->file);

        return $productImage;
    }
}
