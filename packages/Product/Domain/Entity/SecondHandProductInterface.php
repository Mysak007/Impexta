<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface SecondHandProductInterface extends EntityInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getPerex(): ?string;

    public function setPerex(?string $perex): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;

    public function getVatRate(): VatRate;

    public function setVatRate(VatRate $vatRate): void;

    public function getSlug(): string;

    public function setSlug(string $slug): void;

    /**
     * @return ArrayCollection<int, SecondHandProductImageInterface>
     */
    public function getSecondHandProductImages(): Collection;

    public function addSecondHandProductImage(SecondHandProductImageInterface $image): void;

    public function removeSecondHandProductImage(SecondHandProductImageInterface $image): void;

    /**
     * @param ArrayCollection<int, SecondHandProductImageInterface> $images
     */
    public function setSecondHandProductImages(ArrayCollection $images): void;
}
