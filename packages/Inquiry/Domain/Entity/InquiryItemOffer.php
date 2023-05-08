<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class InquiryItemOffer implements InquiryItemOfferInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private InquiryItemRequestInterface $inquiryItemRequest;
    private ProductInterface $product;
    private ?WarehouseProductInterface $warehouseProduct = null;
    private Money $price;

    public function __construct(
        InquiryItemRequestInterface $inquiryItemRequest,
        ProductInterface $product,
        Money $price
    ) {
        $this->inquiryItemRequest = $inquiryItemRequest;
        $this->product = $product;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInquiryItemRequest(): InquiryItemRequestInterface
    {
        return $this->inquiryItemRequest;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getWarehouseProduct(): ?WarehouseProductInterface
    {
        return $this->warehouseProduct;
    }

    public function setWarehouseProduct(?WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProduct = $warehouseProduct;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }
}
