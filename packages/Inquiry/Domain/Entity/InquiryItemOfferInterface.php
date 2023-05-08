<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface InquiryItemOfferInterface extends EntityInterface
{
    public function getId(): int;

    public function getInquiryItemRequest(): InquiryItemRequestInterface;

    public function getProduct(): ProductInterface;

    public function setProduct(ProductInterface $product): void;

    public function getWarehouseProduct(): ?WarehouseProductInterface;

    public function setWarehouseProduct(?WarehouseProductInterface $warehouseProduct): void;

    public function getPrice(): Money;

    public function setPrice(Money $price): void;
}
