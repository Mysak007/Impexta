<?php

declare(strict_types=1);

namespace App\CRM\Controller\Page;

use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Infrastructure\Service\LeastInStockProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractController
{
    private LeastInStockProductService $stockProductService;

    public function __construct(LeastInStockProductService $stockProductService)
    {
        $this->stockProductService = $stockProductService;
    }

    /**
     * @Route("/", name="crm_dashboard")
     */
    public function __invoke(): Response
    {
        $warehouseStocks = [];

        foreach (Warehouse::values() as $warehouse) {
            $warehouseStocks[$warehouse] = $this->stockProductService->getProductsLeastInStockInWarehouse(
                Warehouse::get($warehouse)
            );
        }

        return $this->render(
            'CRM/dashboard.html.twig',
            [
                'warehouseStocks' => $warehouseStocks,
            ]
        );
    }
}
