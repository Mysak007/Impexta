<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\Product\Presentation\Form\Model\SecondHandProductModel;
use Symfony\Component\String\Slugger\SluggerInterface;

final class SecondHandProductFactory
{
    private SecondHandProductImageFactory $imageFactory;
    private SluggerInterface $slugger;

    public function __construct(
        SecondHandProductImageFactory $imageFactory,
        SluggerInterface $slugger
    ) {
        $this->imageFactory = $imageFactory;
        $this->slugger = $slugger;
    }

    public function create(
        SecondHandProductModel $productModel
    ): SecondHandProductInterface {
        $slug = $this->slugger->slug($productModel->name)->toString();

        $product = new SecondHandProduct(
            $productModel->name,
            $productModel->price,
            $productModel->vatRate,
            $slug
        );

        $product->setPerex($productModel->perex);

        $product->setDescription($productModel->description);

        foreach ($productModel->images as $imageModel) {
            $productImage = $this->imageFactory->create($product, $imageModel);
            $product->addSecondHandProductImage($productImage);
        }

        return $product;
    }
}
