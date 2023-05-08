<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class Product implements ProductInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ProductCardInterface $productCard;
    private string $code;
    private string $name;
    private string $slug;
    private string $manufacturer;
    private float $weight;
    private bool $showOnEshop;
    private ?int $leastInStock = null;
    private bool $needsExtraShipping;
    private bool $actionProduct;

    /** @var ArrayCollection<int,ProductImageInterface> $images */
    private Collection $images;

    /** @var ArrayCollection<int,ProductPriceInterface> $prices */
    private Collection $prices;

    /** @var ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    private Collection $warehouseProducts;

    public function __construct(
        ProductCardInterface $productCard,
        string $code,
        string $name,
        string $slug,
        string $manufacturer,
        float $weight,
        bool $showOnEshop,
        bool $needsExtraShipping,
        bool $actionProduct
    ) {
        $this->productCard = $productCard;
        $this->code = $code;
        $this->name = $name;
        $this->slug = $slug;
        $this->manufacturer = $manufacturer;
        $this->weight = $weight;
        $this->showOnEshop = $showOnEshop;
        $this->needsExtraShipping = $needsExtraShipping;
        $this->images = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->warehouseProducts = new ArrayCollection();
        $this->actionProduct = $actionProduct;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductCard(): ProductCardInterface
    {
        return $this->productCard;
    }

    public function setProductCard(ProductCardInterface $productCard): void
    {
        $this->productCard = $productCard;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function isShowOnEshop(): bool
    {
        return $this->showOnEshop;
    }

    public function setShowOnEshop(bool $showOnEshop): void
    {
        $this->showOnEshop = $showOnEshop;
    }

    public function doesNeedsExtraShipping(): bool
    {
        return $this->needsExtraShipping;
    }

    public function setNeedsExtraShipping(bool $needsExtraShipping): void
    {
        $this->needsExtraShipping = $needsExtraShipping;
    }

    public function isActionProduct(): bool
    {
        return $this->actionProduct;
    }

    public function setActionProduct(bool $actionProduct): void
    {
        $this->actionProduct = $actionProduct;
    }

    /**
     * @return ArrayCollection<int, ProductImageInterface>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImageInterface $image): void
    {
        $this->images[] = $image;
    }

    public function removeImage(ProductImageInterface $image): void
    {
        $this->images->removeElement($image);
    }

    /**
     * @param ArrayCollection<int, ProductImageInterface> $images
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    public function getLeastInStock(): ?int
    {
        return $this->leastInStock;
    }

    public function setLeastInStock(?int $leastInStock): void
    {
        $this->leastInStock = $leastInStock;
    }

    /** @return ArrayCollection<int,WarehouseProductInterface> */
    public function getWarehouseProducts(): Collection
    {
        return $this->warehouseProducts;
    }

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->add($warehouseProduct);
    }

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->removeElement($warehouseProduct);
    }

    /** @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void
    {
        $this->warehouseProducts = $warehouseProducts;
    }

    public function countInWarehouse(string $warehouseCode): int
    {
        return $this->warehouseProducts->filter(
            static function (WarehouseProductInterface $warehouseProduct) use ($warehouseCode): bool {
                return $warehouseProduct->getWarehouse()->getValue() === $warehouseCode;
            }
        )->count();
    }

    public function getMainProductImage(): ?ProductImageInterface
    {
        $mainImages = $this->getImages()->filter(
            static function (ProductImageInterface $productImage) {
                return $productImage->isMain() === true;
            }
        );

        if ($mainImages->first() === false) {
            return null;
        }

        return $mainImages->first();
    }

    /** @return ArrayCollection<int, ProductImageInterface> */
    public function getProductImagesWithoutMain(): ?Collection
    {
        $mainImage = $this->getMainProductImage();

        if ($mainImage === null) {
            return $this->getImages();
        }

        return $this->getImages()->filter(
            static function (ProductImageInterface $productImage) use ($mainImage) {
                return $productImage->getId() !== $mainImage->getId();
            }
        );
    }

    /**
     * @return ArrayCollection<int, ProductPriceInterface>
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(ProductPriceInterface $price): void
    {
        $this->getPrices()->add($price);
    }

    /**
     * @param ArrayCollection<int, ProductPriceInterface> $prices
     */
    public function setPrices(Collection $prices): void
    {
        $this->prices = $prices;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
