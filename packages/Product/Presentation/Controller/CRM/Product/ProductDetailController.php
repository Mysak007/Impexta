<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Product;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductPriceRepository;
use Impexta\Product\Infrastructure\Security\ProductCrudVoter;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderItemRepository;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductDetailController extends AbstractController
{
    private WarehouseProductRepository $warehouseProductRepository;
    private ProductPriceRepository $productPriceRepository;
    private WarehouseOrderItemRepository $warehouseOrderItemRepository;

    public function __construct(
        WarehouseProductRepository $warehouseProductRepository,
        ProductPriceRepository $productPriceRepository,
        WarehouseOrderItemRepository $warehouseOrderItemRepository
    ) {
        $this->warehouseProductRepository = $warehouseProductRepository;
        $this->productPriceRepository = $productPriceRepository;
        $this->warehouseOrderItemRepository = $warehouseOrderItemRepository;
    }

    /** @Route("produkt/{id}", name="product_crm_product_detail", requirements={"id"="\d+"}) */
    public function __invoke(Product $product): Response
    {
        $this->denyAccessUnlessGranted(ProductCrudVoter::VIEW, $product);

        $warehouseProductCount = count($this->warehouseProductRepository->findBy(['product' => $product]));
        $productPrices = $this->productPriceRepository->findBy(
            ['product' => $product],
            ['price.currency.code' => 'ASC', 'clientGroup' => 'DESC']
        );
        $warehouseOrders = $this->warehouseOrderItemRepository->findBy(['product' => $product]);

        return $this->render(
            '@product/CRM/product/product_detail.html.twig',
            [
                'product' => $product,
                'warehouseProductCount' => $warehouseProductCount,
                'productPrices' => $productPrices,
                'warehouseOrders' => $warehouseOrders,
            ]
        );
    }
}
