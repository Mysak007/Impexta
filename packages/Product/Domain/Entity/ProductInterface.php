<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ProductInterface extends EntityInterface
{
    public function getId(): int;

    public function getProductCard(): ProductCardInterface;

    public function setProductCard(ProductCardInterface $productCard): void;

    public function getCode(): string;

    public function setCode(string $code): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getSlug(): string;

    public function setSlug(string $slug): void;

    public function getManufacturer(): string;

    public function setManufacturer(string $manufacturer): void;

    public function getWeight(): float;

    public function setWeight(float $weight): void;

    public function isShowOnEshop(): bool;

    public function setShowOnEshop(bool $showOnEshop): void;

    public function doesNeedsExtraShipping(): bool;

    public function setNeedsExtraShipping(bool $needsExtraShipping): void;

    public function isActionProduct(): bool;

    public function setActionProduct(bool $actionProduct): void;

    /**
     * @return ArrayCollection<int, ProductImageInterface>
     */
    public function getImages(): Collection;

    public function addImage(ProductImageInterface $image): void;

    public function removeImage(ProductImageInterface $image): void;

    /**
     * @param ArrayCollection<int, ProductImageInterface> $images
     */
    public function setImages(Collection $images): void;

    public function getLeastInStock(): ?int;

    public function setLeastInStock(?int $leastInStock): void;

    /** @return ArrayCollection<int,WarehouseProductInterface> */
    public function getWarehouseProducts(): Collection;

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    /** @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void;

    public function countInWarehouse(string $warehouseCode): int;

    /**
     * @return ArrayCollection<int, ProductPriceInterface>
     */
    public function getPrices(): Collection;

    public function addPrice(ProductPriceInterface $price): void;

    /**
     * @param ArrayCollection<int, ProductPriceInterface> $prices
     */
    public function setPrices(Collection $prices): void;

    public function getMainProductImage(): ?ProductImageInterface;

    public function __toString(): string;
}
