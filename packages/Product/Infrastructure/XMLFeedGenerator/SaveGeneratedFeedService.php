<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator;

use League\Flysystem\FilesystemOperator;

final class SaveGeneratedFeedService
{
    private FilesystemOperator $xmlFeedStorage;

    public function __construct(FilesystemOperator $xmlFeedStorage)
    {
        $this->xmlFeedStorage = $xmlFeedStorage;
    }

    public function save(string $feedName, string $currencyCode, string $generatedXML): void
    {
        $this->xmlFeedStorage->write($feedName . '_' . $currencyCode . '_new.xml', $generatedXML);

        $this->xmlFeedStorage->move(
            $feedName . '_' . $currencyCode . '_new.xml',
            $feedName . '_' . $currencyCode . '.xml'
        );
    }
}
