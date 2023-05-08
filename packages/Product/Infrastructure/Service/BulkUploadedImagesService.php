<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Service;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Factory\ProductImageFactory;
use Impexta\Product\Presentation\Form\Model\ProductImageModel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class BulkUploadedImagesService
{
    private ProductImageFactory $productImageFactory;

    public function __construct(
        ProductImageFactory $productImageFactory
    ) {
        $this->productImageFactory = $productImageFactory;
    }

    /** @param array<int, UploadedFile> $images */
    public function addUploadedImagesToProduct(array $images, ProductInterface $product): void
    {
        foreach ($images as $image) {
            /** @var ProductImageModel $productImageModel */
            $productImageModel = ProductImageModel::createEmpty();
            $productImageModel->isMain = false;
            $productImageModel->file = $image;
            $productImage = $this->productImageFactory->create($product, $productImageModel);
            $product->addImage($productImage);
        }
    }
}
