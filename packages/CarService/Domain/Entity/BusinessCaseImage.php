<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use DateTimeImmutable;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
class BusinessCaseImage implements BusinessCaseImageInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private BusinessCaseInterface $businessCase;
    private ?string $filename = null;

    /** @Vich\UploadableField(mapping="business_case_image", fileNameProperty="filename") */
    private ?File $file = null;

    public function __construct(BusinessCaseInterface $businessCase)
    {
        $this->businessCase = $businessCase;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBusinessCase(): BusinessCaseInterface
    {
        return $this->businessCase;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;

        if ($file === null) {
            return;
        }

        $this->updatedAt = new DateTimeImmutable();
    }
}
