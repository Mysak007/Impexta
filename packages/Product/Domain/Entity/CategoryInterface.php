<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface CategoryInterface extends EntityInterface
{
    public function getParent(): ?Category;

    public function setParent(?Category $parent): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getSlug(): string;

    public function setSlug(string $slug): void;

    /** @return array<int, CategoryInterface> */
    public function getParents(): array;

    /** @return ArrayCollection<int, ProductCardInterface> */
    public function getProductCards(): Collection;

    /** @return ArrayCollection<int, CategoryInterface> */
    public function getChildren(): Collection;

    public function getPosition(): ?int;

    public function setPosition(?int $position): void;
}
