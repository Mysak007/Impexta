<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Service;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Presentation\Form\Model\ClientModel;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadedFileService
{
    private FileHandler $fileHandler;

    public function __construct(
        FileHandler $fileHandler
    ) {
        $this->fileHandler = $fileHandler;
    }

    public function uploadLogo(FormInterface $form, ClientInterface $client): void
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form->get('logo')->getData();
        $originalFileName = $uploadedFile->getClientOriginalName();
        $newFileName = Uuid::uuid4()->toString();
        $newFileName .= $originalFileName;
        $this->fileHandler->saveImage($newFileName, $uploadedFile);
        $client->setLogo($newFileName);
    }

    public function updateLogo(FormInterface $form, ClientModel $clientModel, Client $client): void
    {
        $oldFile = $clientModel->logo;
        $uploadedFile = $form->get('logo')->getData();
        $originalFileName = $uploadedFile->getClientOriginalName();
        $newFileName = Uuid::uuid4()->toString();
        $newFileName .= $originalFileName;

        $this->fileHandler->updateImage($newFileName, $uploadedFile, $oldFile);
        $client->setLogo($newFileName);
    }
}
