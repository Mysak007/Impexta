<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseIssue;

use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseIssueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListWarehouseIssueController extends AbstractController
{
    private WarehouseIssueRepository $warehouseIssueRepository;

    public function __construct(
        WarehouseIssueRepository $warehouseIssueRepository
    ) {
        $this->warehouseIssueRepository = $warehouseIssueRepository;
    }

    /** @Route("sklad/{warehouse}/vydejky", name="warehouse_crm_warehouse_issue_list") */
    public function __invoke(Warehouse $warehouse): Response
    {
        $warehouseIssues = $this->warehouseIssueRepository->findByWarehouse($warehouse);

        return $this->render(
            '@warehouse/CRM/issue/warehouse_issue_list.html.twig',
            [
                'warehouse' => $warehouse,
                'warehouseIssues' => $warehouseIssues,
            ]
        );
    }
}
