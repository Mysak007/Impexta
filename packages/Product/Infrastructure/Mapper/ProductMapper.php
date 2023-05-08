<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Mapper;

use Impexta\Product\Domain\Entity\ProductImageInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Factory\ProductImageFactory;
use Impexta\Product\Infrastructure\Repository\ProductImageRepository;
use Impexta\Product\Presentation\Form\Model\ProductImageModel;
use Impexta\Product\Presentation\Form\Model\ProductModel;

final class ProductMapper
{
    private ProductImageFactory $imageFactory;
    private ProductImageRepository $imageRepository;

    public function __construct(
        ProductImageFactory $productImageFactory,
        ProductImageRepository $productImageRepository
    ) {
        $this->imageFactory = $productImageFactory;
        $this->imageRepository = $productImageRepository;
    }

    public function mapFromModel(ProductModel $model, ProductInterface $product): void
    {
        $product->setProductCard($model->productCard);
        $product->setCode($model->code);
        $product->setName($model->name);
        $product->setSlug($model->slug);
        $product->setManufacturer($model->manufacturer);
        $product->setWeight($model->weight);
        $product->setNeedsExtraShipping($model->needsExtraShipping);
        $product->setLeastInStock($model->leastInStock);
        $product->setShowOnEshop($model->showOnEshop);

        $modelImages = $model->images;

        /** @var ProductImageModel $image */
        foreach ($modelImages as $key => $image) {
            // New images
            if (!$image->filename && $image->file) {
                $newImage = $this->imageFactory->create($product, $image);
                $product->addImage($newImage);

                continue;
            }

            /** @var ProductImageInterface|null $productImage */
            $productImage = $product->getImages()->get($key);

            // User created new image entity but did not upload any file
            if (!$productImage) {
                continue;
            }

            // Changed image
            $productImage->setFile($image->file);

            // Images to delete
            if (!$image->filename && !$image->file) {
                $product->removeImage($productImage);
                $this->imageRepository->remove($productImage);

                continue;
            }

            // Existing images we want to keep
            $productImage->setIsMain($image->isMain);
        }
    }
}
