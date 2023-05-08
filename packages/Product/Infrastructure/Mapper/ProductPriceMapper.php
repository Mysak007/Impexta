<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Mapper;

use Impexta\Product\Domain\Entity\ProductPriceInterface;
use Impexta\Product\Presentation\Form\Model\ProductPriceModel;

final class ProductPriceMapper
{
    public function mapFromModel(ProductPriceInterface $productPrice, ProductPriceModel $productPriceModel): void
    {
        $productPrice->setPrice($productPriceModel->price);
        $productPrice->setClientGroup($productPriceModel->clientGroup);
    }
}
