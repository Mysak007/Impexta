<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Entity\ProductPrice;
use Impexta\Product\Domain\Entity\ProductPriceInterface;
use Impexta\Product\Presentation\Form\Model\ProductPriceModel;

final class ProductPriceFactory
{
    public function create(ProductPriceModel $productPriceModel, ProductInterface $product): ProductPriceInterface
    {
        $productPrice = new ProductPrice(
            $product,
            $productPriceModel->price
        );

        $productPrice->setClientGroup($productPriceModel->clientGroup);

        return $productPrice;
    }
}
