<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseProduct;

use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListWarehouseProductController extends AbstractController
{
    private WarehouseProductRepository $warehouseProductRepository;

    public function __construct(
        WarehouseProductRepository $warehouseProductRepository
    ) {
        $this->warehouseProductRepository = $warehouseProductRepository;
    }

    /** @Route("sklad/{warehouse}", name="warehouse_crm_warehouse_product_list") */
    public function __invoke(Warehouse $warehouse): Response
    {
        $warehouseProducts = $this->warehouseProductRepository->getWarehouseProductsWithOnStockQuantity($warehouse);

        return $this->render(
            '@warehouse/CRM/product/warehouse_product_list.html.twig',
            [
                'warehouse' => $warehouse,
                'warehouseProducts' => $warehouseProducts,
            ]
        );
    }
}
