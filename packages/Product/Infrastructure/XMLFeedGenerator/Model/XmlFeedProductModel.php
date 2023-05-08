<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Model;

use DateTimeImmutable;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Impexta\Product\Domain\Entity\ProductImageInterface;
use Impexta\Product\Domain\Enum\VatRate;
use Money\Currency;
use Money\Money;

final class XmlFeedProductModel
{
    public int $id;
    public int $productCardId;
    public CategoryInterface $category;
    public ?ProductImageInterface $mainImage;

    /** @var array<int,ProductImageInterface>|null $images */
    public ?array $images;
    public VatRate $vatRate;
    public string $name;
    public string $description;
    public string $manufacturer;
    public int $onStock;
    public ?DateTimeImmutable $deliveryDate;

    /** @var array<int,XmlFeedProductPriceModel>|null $prices */
    public ?array $prices;
    public string $slug;

    /** @var array<int, XmlFeedProductShippingModel> $shippings */
    public array $shippings;

    /**
     * @param array<int, XmlFeedProductShippingModel> $shippings
     * @param array<int, ProductImageInterface>|null $images
     * @param array<int, XmlFeedProductPriceModel>|null $prices
     * @SuppressWarnings("PHPMD.ExcessiveParameterList")
     */
    public function __construct(
        int $id,
        int $productCardId,
        CategoryInterface $category,
        ?ProductImageInterface $mainImage,
        ?array $images,
        VatRate $vatRate,
        string $name,
        string $description,
        string $manufacturer,
        int $onStock,
        ?DateTimeImmutable $deliveryDate,
        ?array $prices,
        string $slug,
        array $shippings
    ) {
        $this->id = $id;
        $this->productCardId = $productCardId;
        $this->mainImage = $mainImage;
        $this->images = $images;
        $this->category = $category;
        $this->vatRate = $vatRate;
        $this->name = $name;
        $this->description = $description;
        $this->manufacturer = $manufacturer;
        $this->onStock = $onStock;
        $this->deliveryDate = $deliveryDate;
        $this->prices = $prices;
        $this->slug = $slug;
        $this->shippings = $shippings;
    }

    public function hasPriceInCurrency(Currency $currency): bool
    {
        if (is_array($this->prices)) {
            foreach ($this->prices as $price) {
                if ($price->currency->getCode() === $currency->getCode()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPriceInCurrency(Currency $currency): ?Money
    {
        if (is_array($this->prices)) {
            foreach ($this->prices as $price) {
                if ($price->currency->getCode() === $currency->getCode()) {
                    return $price->price;
                }
            }
        }

        return null;
    }
}
