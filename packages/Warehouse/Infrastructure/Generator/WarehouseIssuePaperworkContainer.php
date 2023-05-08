<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Generator;

use Beganovich\Snappdf\Snappdf;
use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use League\Flysystem\FilesystemOperator;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class WarehouseIssuePaperworkContainer
{
    private FilesystemOperator $warehouseIssuePdfStorage;
    private Snappdf $snapPdf;
    private WarehouseIssuePaperworkGenerator $warehouseIssuePaperworkGenerator;

    public function __construct(
        WarehouseIssuePaperworkGenerator $warehouseIssuePaperworkGenerator,
        FilesystemOperator $warehouseIssuePdfStorage,
        Snappdf $snapPdf
    ) {
        $this->warehouseIssuePdfStorage = $warehouseIssuePdfStorage;
        $this->snapPdf = $snapPdf;
        $this->warehouseIssuePaperworkGenerator = $warehouseIssuePaperworkGenerator;
    }

    public function generate(WarehouseIssue $warehouseIssue): void
    {
        $filename = $warehouseIssue->getId() . '.pdf';

        $template = $this->warehouseIssuePaperworkGenerator->generate($warehouseIssue);

        $this->snapPdf->setHtml($template);

        /** @var string $generatedPdf */
        $generatedPdf = $this->snapPdf->generate();

        $this->warehouseIssuePdfStorage->delete($filename);
        $this->warehouseIssuePdfStorage->write($warehouseIssue->getId() . '.pdf', $generatedPdf);
    }
}
