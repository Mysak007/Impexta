<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseOrder;

use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListWarehouseOrderController extends AbstractController
{
    private WarehouseOrderRepository $warehouseOrderRepository;

    public function __construct(
        WarehouseOrderRepository $warehouseOrderRepository
    ) {
        $this->warehouseOrderRepository = $warehouseOrderRepository;
    }

    /** @Route("sklad/objednavky", name="warehouse_crm_warehouse_order_list") */
    public function __invoke(): Response
    {
        $orders = $this->warehouseOrderRepository->findOpenOrders();

        return $this->render(
            '@warehouse/CRM/order/warehouse_order_list.html.twig',
            [
                'orders' => $orders,
                'order' => WarehouseOrder::class,
            ]
        );
    }
}
