<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Service;

use DateTimeImmutable;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;

final class DeliveryDateResolver
{
    private WarehouseProductRepository $productRepository;

    public function __construct(WarehouseProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getDeliveryDate(ProductInterface $product): ?DateTimeImmutable
    {
        $warehouseProduct = $this->productRepository->findOneBy(['product' => $product]);

        if (!$warehouseProduct) {
            return null;
        }

        return new DateTimeImmutable('NOW + 2 days');
    }
}
