<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class SecondHandProduct implements SecondHandProductInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;
    private ?string $perex = null;
    private ?string $description = null;
    private Money $price;
    private VatRate $vatRate;
    private string $slug;

    /** @var ArrayCollection<int, SecondHandProductImageInterface> $images */
    private Collection $images;

    public function __construct(
        string $name,
        Money $price,
        VatRate $vatRate,
        string $slug
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->vatRate = $vatRate;
        $this->images = new ArrayCollection();
        $this->slug = $slug;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPerex(): ?string
    {
        return $this->perex;
    }

    public function setPerex(?string $perex): void
    {
        $this->perex = $perex;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getVatRate(): VatRate
    {
        return $this->vatRate;
    }

    public function setVatRate(VatRate $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return ArrayCollection<int, SecondHandProductImageInterface>
     */
    public function getSecondHandProductImages(): Collection
    {
        return $this->images;
    }

    /** @SuppressWarnings(PHPMD.UnusedLocalVariable) */
    public function addSecondHandProductImage(SecondHandProductImageInterface $image): void
    {
        $images = $this->getSecondHandProductImages()->add($image);
    }

    public function removeSecondHandProductImage(SecondHandProductImageInterface $image): void
    {
        $this->images->removeElement($image);
    }

    /**
     * @param ArrayCollection<int, SecondHandProductImageInterface> $images
     */
    public function setSecondHandProductImages(ArrayCollection $images): void
    {
        $this->images = $images;
    }

    public function getMainSecondHandProductImage(): ?SecondHandProductImageInterface
    {
        $mainImages = $this->getSecondHandProductImages()->filter(
            static function (SecondHandProductImageInterface $secondHandProductImage) {
                return $secondHandProductImage->isMain() === true;
            }
        );

        if ($mainImages->first() === false) {
            if ($this->getSecondHandProductImages()->first() === false) {
                return null;
            }

            return $this->getSecondHandProductImages()->first();
        }

        return $mainImages->first();
    }

    /** @return Collection<int, SecondHandProductImageInterface> */
    public function getSecondHandProductImagesWithoutMain(): ?Collection
    {
        $mainImage = $this->getMainSecondHandProductImage();

        if ($mainImage === null) {
            return $this->getSecondHandProductImages();
        }

        return $this->getSecondHandProductImages()->filter(
            static function (SecondHandProductImageInterface $secondHandProductImage) use ($mainImage) {
                return $secondHandProductImage->getId() !== $mainImage->getId();
            }
        );
    }
}
