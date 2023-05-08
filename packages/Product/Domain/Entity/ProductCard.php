<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ProductCard implements ProductCardInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private CategoryInterface $category;
    private ?string $originalCode = null;
    private string $name;
    private VatRate $vatRate;
    private Guarantee $guarantee;
    private ?string $description = null;
    private ?string $note = null;

    /** @var ArrayCollection<int, CompatibleCarInterface> $cars */
    private Collection $cars;

    /** @var ArrayCollection<int, ProductInterface> $products */
    private Collection $products;

    public function __construct(
        CategoryInterface $category,
        string $name,
        VatRate $vatRate,
        Guarantee $guarantee
    ) {
        $this->category = $category;
        $this->name = $name;
        $this->vatRate = $vatRate;
        $this->guarantee = $guarantee;
        $this->cars = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategory(): CategoryInterface
    {
        return $this->category;
    }

    public function setCategory(CategoryInterface $category): void
    {
        $this->category = $category;
    }

    public function getOriginalCode(): ?string
    {
        return $this->originalCode;
    }

    public function setOriginalCode(?string $originalCode): void
    {
        $this->originalCode = $originalCode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getVatRate(): VatRate
    {
        return $this->vatRate;
    }

    public function setVatRate(VatRate $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    public function getGuarantee(): Guarantee
    {
        return $this->guarantee;
    }

    public function setGuarantee(Guarantee $guarantee): void
    {
        $this->guarantee = $guarantee;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /** @return Collection<int, CompatibleCarInterface> */
    public function getCompatibleCars(): Collection
    {
        return $this->cars;
    }

    public function addCompatibleCar(CompatibleCarInterface $car): void
    {
        $cars = $this->getCompatibleCars();
        $cars->add($car);
    }

    public function removeCompatibleCar(CompatibleCarInterface $car): void
    {
        $this->cars->removeElement($car);
    }

    /** @param ArrayCollection<int, CompatibleCarInterface> $cars */
    public function setCompatibleCars(ArrayCollection $cars): void
    {
        $this->cars = $cars;
    }

    /** @return Collection<int, ProductInterface> */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
