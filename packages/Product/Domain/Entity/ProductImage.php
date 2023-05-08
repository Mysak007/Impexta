<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use DateTimeImmutable;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
class ProductImage implements ProductImageInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ProductInterface $product;
    private bool $isMain;
    private ?string $filename = null;

    /** @Vich\UploadableField(mapping="product_image", fileNameProperty="filename") */
    private ?File $file = null;

    public function __construct(
        ProductInterface $product,
        bool $isMain
    ) {
        $this->product = $product;
        $this->isMain = $isMain;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): void
    {
        $this->isMain = $isMain;
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
