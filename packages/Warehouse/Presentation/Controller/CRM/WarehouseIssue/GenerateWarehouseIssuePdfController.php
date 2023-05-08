<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseIssue;

use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use Impexta\Warehouse\Infrastructure\Generator\WarehouseIssuePaperworkContainer;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class GenerateWarehouseIssuePdfController extends AbstractController
{
    private FilesystemOperator $warehouseIssuePdfStorage;
    private WarehouseIssuePaperworkContainer $warehouseIssuePaperworkContainer;

    public function __construct(
        FilesystemOperator $warehouseIssuePdfStorage,
        WarehouseIssuePaperworkContainer $warehouseIssuePaperworkContainer
    ) {
        $this->warehouseIssuePdfStorage = $warehouseIssuePdfStorage;
        $this->warehouseIssuePaperworkContainer = $warehouseIssuePaperworkContainer;
    }

    private function createFileResponse(string $fileContent, string $filename): Response
    {
        $response = new Response($fileContent);

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }

    /**
     * @Route("/sklad/vydej/{id}/pdf", name="inquiry_crm_warehouse_issue_generate_pdf")
     */
    public function __invoke(WarehouseIssue $warehouseIssue): Response
    {
        $filename = $warehouseIssue->getId() . '.pdf';
        $publicFilename = sprintf('Vydej %d', $warehouseIssue->getId());

        if (
            $this->warehouseIssuePdfStorage->fileExists($filename) &&
            $this->warehouseIssuePdfStorage->lastModified($filename) >= $warehouseIssue->getUpdatedAt()->getTimestamp()
        ) {
            return $this->createFileResponse(
                $this->warehouseIssuePdfStorage->read($filename),
                $publicFilename
            );
        }

        $this->warehouseIssuePaperworkContainer->generate($warehouseIssue);
        $generatedPdf = $this->warehouseIssuePdfStorage->read($filename);

        return $this->createFileResponse(
            $generatedPdf,
            $publicFilename
        );
    }
}
