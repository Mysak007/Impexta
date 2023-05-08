<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseOrder;

use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Infrastructure\Security\WarehouseOrderVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailWarehouseOrderController extends AbstractController
{
    /** @Route("sklad/objednavka/{id}", name="warehouse_crm_warehouse_order_detail") */

    public function __invoke(WarehouseOrder $warehouseOrder): Response
    {
        $this->denyAccessUnlessGranted(WarehouseOrderVoter::VIEW, $warehouseOrder);

        return $this->render(
            '@warehouse/CRM/order/warehouse_order_detail.html.twig',
            [
                'order' => $warehouseOrder,
            ]
        );
    }
}
