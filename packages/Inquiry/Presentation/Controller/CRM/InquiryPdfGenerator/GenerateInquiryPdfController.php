<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\InquiryPdfGenerator;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Generator\InquiryPaperworkContainer;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

final class GenerateInquiryPdfController extends AbstractController
{
    private FilesystemOperator $inquiryPdfStorage;
    private InquiryPaperworkContainer $inquiryPaperworkContainer;

    public function __construct(
        FilesystemOperator $inquiryPdfStorage,
        InquiryPaperworkContainer $inquiryPaperworkContainer
    ) {
        $this->inquiryPdfStorage = $inquiryPdfStorage;
        $this->inquiryPaperworkContainer = $inquiryPaperworkContainer;
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
     * @Route("/poptavka/{id}/pdf", name="inquiry_crm_inquiry_generate_pdf")
     */
    public function __invoke(Inquiry $inquiry): Response
    {
        $filename = $inquiry->getId() . '.pdf';
        $publicFilename = sprintf('Poptavka %d', $inquiry->getId());

        if (
            $this->inquiryPdfStorage->fileExists($filename) &&
            $this->inquiryPdfStorage->lastModified($filename) >= $inquiry->getUpdatedAt()->getTimestamp()
        ) {
            return $this->createFileResponse(
                $this->inquiryPdfStorage->read($filename),
                $publicFilename
            );
        }

        $this->inquiryPaperworkContainer->generate($inquiry);
        $generatedPdf = $this->inquiryPdfStorage->read($filename);

        return $this->createFileResponse(
            $generatedPdf,
            $publicFilename
        );
    }
}
