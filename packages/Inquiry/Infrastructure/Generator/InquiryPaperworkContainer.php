<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Generator;

use Beganovich\Snappdf\Snappdf;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use League\Flysystem\FilesystemOperator;

final class InquiryPaperworkContainer
{
    private InquiryPaperworkGenerator $inquiryPaperworkGenerator;
    private FilesystemOperator $inquiryPdfStorage;
    private Snappdf $snapPdf;

    public function __construct(
        InquiryPaperworkGenerator $inquiryPaperworkGenerator,
        FilesystemOperator $inquiryPdfStorage,
        Snappdf $snapPdf
    ) {
        $this->inquiryPaperworkGenerator = $inquiryPaperworkGenerator;
        $this->inquiryPdfStorage = $inquiryPdfStorage;
        $this->snapPdf = $snapPdf;
    }

    public function generate(Inquiry $inquiry): void
    {
        $filename = $inquiry->getId() . '.pdf';

        $template = $this->inquiryPaperworkGenerator->generate($inquiry);

        $this->snapPdf->setHtml($template);

        /** @var string $generatedPdf */
        $generatedPdf = $this->snapPdf->generate();

        $this->inquiryPdfStorage->delete($filename);
        $this->inquiryPdfStorage->write($inquiry->getId() . '.pdf', $generatedPdf);
    }
}
