<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Generator;

use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use Twig\Environment;

final class WarehouseIssuePaperworkGenerator
{
    private Environment $twig;
    private WarehouseIssueNumberGenerator $warehouseIssueNumberGenerator;

    public function __construct(
        Environment $twig,
        WarehouseIssueNumberGenerator $warehouseIssueNumberGenerator
    ) {
        $this->twig = $twig;
        $this->warehouseIssueNumberGenerator = $warehouseIssueNumberGenerator;
    }

    public function generate(WarehouseIssue $warehouseIssue): string
    {
        $issueId = $this->warehouseIssueNumberGenerator->generateIssueNumber();

        return $this->twig->render(
            '@warehouse/CRM/issue/pdf_template.html.twig',
            [
                'issueId' => $issueId,
                'warehouseIssue' => $warehouseIssue,
            ]
        );
    }
}
