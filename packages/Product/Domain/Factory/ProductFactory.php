<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Presentation\Form\Model\ProductModel;

final class ProductFactory
{
    private ProductImageFactory $imageFactory;

    public function __construct(
        ProductImageFactory $imageFactory
    ) {
        $this->imageFactory = $imageFactory;
    }

    public function create(
        ProductModel $productModel
    ): ProductInterface {
        $product = new Product(
            $productModel->productCard,
            $productModel->code,
            $productModel->name,
            $productModel->slug,
            $productModel->manufacturer,
            $productModel->weight,
            $productModel->showOnEshop,
            $productModel->needsExtraShipping,
            $productModel->actionProduct
        );

        $product->setLeastInStock($productModel->leastInStock);

        foreach ($productModel->images as $imageModel) {
            $productImage = $this->imageFactory->create($product, $imageModel);
            $product->addImage($productImage);
        }

        return $product;
    }
}
