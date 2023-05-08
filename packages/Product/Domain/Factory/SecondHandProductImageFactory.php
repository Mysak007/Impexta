<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\SecondHandProductImage;
use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\Product\Presentation\Form\Model\SecondHandProductImageModel;

final class SecondHandProductImageFactory
{
    public function create(
        SecondHandProductInterface $secondHandProduct,
        SecondHandProductImageModel $imageModel
    ): SecondHandProductImage {
        $productImage = new SecondHandProductImage(
            $secondHandProduct,
            $imageModel->isMain
        );

        $productImage->setFile($imageModel->file);

        return $productImage;
    }
}
