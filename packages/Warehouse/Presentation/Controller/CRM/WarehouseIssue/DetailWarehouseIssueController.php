<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseIssue;

use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailWarehouseIssueController extends AbstractController
{
    /**
     * @Route("sklad/{warehouse}/vydejka/{id}", name="warehouse_crm_warehouse_issue_detail")
     * @ParamConverter("warehouseOrder", options={"id" = "id"})
     */

    public function __invoke(WarehouseIssue $warehouseIssue): Response
    {
        return $this->render(
            '@warehouse/CRM/issue/warehouse_issue_detail.html.twig',
            [
                'warehouseIssue' => $warehouseIssue,
            ]
        );
    }
}
