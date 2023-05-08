<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Service;

use Impexta\Inquiry\Infrastructure\Repository\InquiryItemOfferRepository;
use Impexta\Order\Infrastructure\Repository\OrderItemRepository;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\Repository\ProductImageRepository;
use Impexta\Product\Infrastructure\Repository\ProductPriceRepository;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderItemRepository;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;

final class CheckProductBindingsService
{
    private OrderItemRepository $orderItemRepository;
    private InquiryItemOfferRepository $inquiryItemOfferRepository;
    private ProductPriceRepository $productPriceRepository;
    private ProductImageRepository $productImageRepository;
    private WarehouseOrderItemRepository $warehouseOrderItemRepository;
    private WarehouseProductRepository $warehouseProductRepository;

    public function __construct(
        OrderItemRepository $orderItemRepository,
        InquiryItemOfferRepository $inquiryItemOfferRepository,
        ProductPriceRepository $productPriceRepository,
        ProductImageRepository $productImageRepository,
        WarehouseOrderItemRepository $warehouseOrderItemRepository,
        WarehouseProductRepository $warehouseProductRepository
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->inquiryItemOfferRepository = $inquiryItemOfferRepository;
        $this->productPriceRepository = $productPriceRepository;
        $this->productImageRepository = $productImageRepository;
        $this->warehouseOrderItemRepository = $warehouseOrderItemRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
    }

    public function isSafeToDeleteProduct(ProductInterface $product): bool
    {
        $orderItem = $this->orderItemRepository->findOneBy(['product' => $product->getId()]);
        $inquiryItemOffer = $this->inquiryItemOfferRepository->findOneBy(['product' => $product->getId()]);
        $productPrice = $this->productPriceRepository->findOneBy(['product' => $product->getId()]);
        $productImage = $this->productImageRepository->findOneBy(['product' => $product->getId()]);
        $warehouseOrderItem = $this->warehouseOrderItemRepository->findOneBy(['product' => $product->getId()]);
        $warehouseProduct = $this->warehouseProductRepository->findOneBy(['product' => $product->getId()]);

        return !($orderItem ||
            $inquiryItemOffer ||
            $productPrice ||
            $productImage ||
            $warehouseOrderItem ||
            $warehouseProduct);
    }
}
