<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseOrder;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Domain\Factory\StockWarehouseOrderFactory;
use Impexta\Warehouse\Infrastructure\Service\LeastInStockProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class LeastInStockWarehouseOrderController extends AbstractController
{
    private StockWarehouseOrderFactory $orderFactory;
    private LeastInStockProductService $stockProductService;

    public function __construct(
        StockWarehouseOrderFactory $orderFactory,
        LeastInStockProductService $stockProductService
    ) {
        $this->orderFactory = $orderFactory;
        $this->stockProductService = $stockProductService;
    }

    /**
     * @Route("/sklad/{warehouse}/objednat", name="warehouse_crm_warehouse_order_least_in_stock")
     * @param AdminUserInterface $user
     */
    public function __invoke(Warehouse $warehouse, UserInterface $user): Response
    {
        $orderItems = $this->stockProductService->getProductsLeastInStockInWarehouse($warehouse);

        if ($orderItems) {
            $this->orderFactory->create($warehouse, $orderItems[0], $user);
            $this->addFlash('success', 'Objednávka na sklad ' . $warehouse->getReadable() . ' byla vytvořena.');
        }

        return $this->redirectToRoute('crm_dashboard');
    }
}
