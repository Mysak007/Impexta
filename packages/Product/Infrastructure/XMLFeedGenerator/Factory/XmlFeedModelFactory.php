<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Factory;

use DateTimeImmutable;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Infrastructure\Service\DeliveryDateResolver;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedModel;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedProductModel;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;

/** @SuppressWarnings(PHPMD.LongVariable) */
final class XmlFeedModelFactory
{
    private ProductRepository $productRepository;
    private WarehouseProductRepository $warehouseProductRepository;
    private DeliveryDateResolver $deliveryDateResolver;
    private XmlFeedProductShippingModelFactory $xmlFeedProductShippingModelFactory;
    private XmlFeedProductPriceModelFactory $xmlFeedProductPriceModelFactory;

    public function __construct(
        ProductRepository $productRepository,
        WarehouseProductRepository $warehouseProductRepository,
        DeliveryDateResolver $deliveryDateResolver,
        XmlFeedProductShippingModelFactory $xmlFeedProductShippingModelFactory,
        XmlFeedProductPriceModelFactory $xmlFeedProductPriceModelFactory
    ) {
        $this->productRepository = $productRepository;
        $this->warehouseProductRepository = $warehouseProductRepository;
        $this->deliveryDateResolver = $deliveryDateResolver;
        $this->xmlFeedProductShippingModelFactory = $xmlFeedProductShippingModelFactory;
        $this->xmlFeedProductPriceModelFactory = $xmlFeedProductPriceModelFactory;
    }

    public function mapXMLFeedModel(): XmlFeedModel
    {
        $products = $this->productRepository->findProductsForEshop();

        if (!$products) {
            return new XmlFeedModel([], new DateTimeImmutable('NOW'));
        }

        $productModels = [];

        /* create shipping models */
        $shippings = $this->xmlFeedProductShippingModelFactory->create();

        /* create product models */
        foreach ($products as $product) {
            $productCard = $product->getProductCard();
            $stockCount = 0;
            $stockProducts = $this->warehouseProductRepository->findBy(['product' => $product]);

            if ($stockProducts) {
                $stockCount = count($stockProducts);
            }

            /* create prices models */
            $prices = $this->xmlFeedProductPriceModelFactory->create($product);

            $productModels[] = new XmlFeedProductModel(
                $product->getId(),
                $productCard->getId(),
                $productCard->getCategory(),
                $product->getMainProductImage(),
                $product->getProductImagesWithoutMain() ? $product->getProductImagesWithoutMain()->toArray() : null,
                $productCard->getVatRate(),
                $product->getName(),
                $productCard->getDescription() ?? '',
                $product->getManufacturer(),
                $stockCount,
                $this->deliveryDateResolver->getDeliveryDate($product),
                $prices,
                $product->getSlug(),
                $shippings
            );
        }

        return new XmlFeedModel($productModels, new DateTimeImmutable('NOW'));
    }
}
