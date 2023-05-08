<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Command;

use DateTimeImmutable;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\StorageAttributes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InquiryPdfGarbageCollectorCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:inquiry-pdf-garbage-collector';
    private FilesystemOperator $inquiryPdfStorage;

    public function __construct(FilesystemOperator $inquiryPdfStorage)
    {
        $this->inquiryPdfStorage = $inquiryPdfStorage;

        parent::__construct();
    }

    /** @SuppressWarnings("PHPMD.UnusedFormalParameter") */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $files = $this->inquiryPdfStorage->listContents('')
            ->filter(static fn (StorageAttributes $attributes) => $attributes->isFile())
            ->map(static fn (StorageAttributes $attributes) => $attributes->path())
            ->toArray();

        $compareDate = new DateTimeImmutable('NOW - 1 month');
        $compareTimestamp = $compareDate->getTimestamp();

        foreach ($files as $file) {
            if ($this->inquiryPdfStorage->lastModified($file) >= $compareTimestamp) {
                continue;
            }

            $this->inquiryPdfStorage->delete($file);
        }

        return Command::SUCCESS;
    }
}
