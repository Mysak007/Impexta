<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Service;

use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Warehouse\Domain\Enum\Warehouse;

final class LeastInStockProductService
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @return array<int,mixed>|null
     */
    public function getProductsLeastInStockInWarehouse(Warehouse $warehouse): ?array
    {
        $notInStock = [];
        /** @var string $warehouseName */
        $warehouseName = $warehouse->getValue();
        $products = $this->productRepository->findLeastCountProductsForWarehouse($warehouseName);

        if ($products === []) {
            return null;
        }

        $notInStock[] = $products;

        return $notInStock;
    }
}
