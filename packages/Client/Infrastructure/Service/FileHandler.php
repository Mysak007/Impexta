<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Service;

use InvalidArgumentException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileHandler
{
    private FilesystemOperator $secondHandProductStorage;

    public function __construct(
        FilesystemOperator $secondHandProductStorage
    ) {
        $this->secondHandProductStorage = $secondHandProductStorage;
    }

    public function saveImage(string $fileName, UploadedFile $uploadedFile): void
    {
        $filePath = $uploadedFile->getRealPath();

        if (!$filePath) {
            throw new InvalidArgumentException();
        }

        $file = file_get_contents($filePath);

        if (!$file) {
            throw new InvalidArgumentException();
        }

        $this->secondHandProductStorage->write($fileName, $file);
    }

    public function updateImage(string $fileName, UploadedFile $uploadedFile, ?string $fileToDelete): void
    {
        if (isset($fileToDelete)) {
            $this->secondHandProductStorage->delete($fileToDelete);
        }

        $filePath = $uploadedFile->getRealPath();

        if (!$filePath) {
            throw new InvalidArgumentException();
        }

        $file = file_get_contents($filePath);

        if (!$file) {
            throw new InvalidArgumentException();
        }

        $this->secondHandProductStorage->write($fileName, $file);
    }
}
