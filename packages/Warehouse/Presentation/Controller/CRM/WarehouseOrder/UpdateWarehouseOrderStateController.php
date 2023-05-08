<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseOrder;

use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderRepository;
use Impexta\Warehouse\Infrastructure\Service\WarehouseOrderStateTransitioner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateWarehouseOrderStateController extends AbstractController
{
    private WarehouseOrderStateTransitioner $stateTransitioner;
    private WarehouseOrderRepository $warehouseOrderRepository;

    public function __construct(
        WarehouseOrderStateTransitioner $stateTransitioner,
        WarehouseOrderRepository $warehouseOrderRepository
    ) {
        $this->stateTransitioner = $stateTransitioner;
        $this->warehouseOrderRepository = $warehouseOrderRepository;
    }

    /** @Route("objednavka/{id}/{transition}", name="warehouse_crm_warehouse_order_update_state") */
    public function __invoke(WarehouseOrder $warehouseOrder, string $transition): Response
    {
        $this->stateTransitioner->changeWarehouseOrderState($warehouseOrder, $transition);

        $this->warehouseOrderRepository->save($warehouseOrder);

        return $this->redirectToRoute('warehouse_crm_warehouse_order_detail', ['id' => $warehouseOrder->getId()]);
    }
}
