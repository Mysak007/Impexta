<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ProductCardInterface extends EntityInterface
{
    public function getCategory(): CategoryInterface;

    public function setCategory(CategoryInterface $category): void;

    public function getOriginalCode(): ?string;

    public function setOriginalCode(?string $originalCode): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getVatRate(): VatRate;

    public function setVatRate(VatRate $vatRate): void;

    public function getGuarantee(): Guarantee;

    public function setGuarantee(Guarantee $guarantee): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /** @return Collection<int, CompatibleCarInterface> */
    public function getCompatibleCars(): Collection;

    public function addCompatibleCar(CompatibleCarInterface $car): void;

    public function removeCompatibleCar(CompatibleCarInterface $car): void;

    /** @param ArrayCollection<int, CompatibleCarInterface> $cars */
    public function setCompatibleCars(ArrayCollection $cars): void;

    /** @return Collection<int, ProductInterface> */
    public function getProducts(): Collection;

    public function __toString(): string;
}
