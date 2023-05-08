<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class Category implements CategoryInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ?Category $parent = null;
    private string $name;
    private string $slug;
    private ?int $position = null;

    /** @var ArrayCollection<int, ProductCardInterface> $productCards */
    private Collection $productCards;

    /** @var ArrayCollection<int, CategoryInterface> $children */
    private Collection $children;

    public function __construct(
        string $name,
        string $slug
    ) {
        $this->name = $name;
        $this->slug = $slug;
        $this->productCards = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setParent(?Category $parent): void
    {
        $this->parent = $parent;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /** @return array<int, CategoryInterface> */
    public function getParents(): array
    {
        $tree = [];
        $tree[] = $this;
        $parent = $this->getParent();

        do {
            if (!$parent) {
                continue;
            }

            $tree[] = $parent;
            $parent = $parent->getParent();
        } while ($parent);

        return array_reverse($tree);
    }

    /** @return ArrayCollection<int, ProductCardInterface> */
    public function getProductCards(): Collection
    {
        return $this->productCards;
    }

    /** @return ArrayCollection<int, CategoryInterface> */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
