<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Impexta\Inquiry\Domain\Entity\InquiryItemOfferInterface;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class InquiryItemOfferModel implements ModelInterface
{
    /** @Assert\Valid */
    public InquiryItemRequestInterface $inquiryItemRequest;

    /** @Assert\Valid */
    public ProductInterface $product;

    /** @Assert\Valid */
    public ?WarehouseProductInterface $warehouseProduct = null;

    /** @Assert\NotBlank(message="Musí být vyplněna cena") */
    public Money $price;

    /** @param InquiryItemOfferInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = self::createEmpty();
        $model->inquiryItemRequest = $entity->getInquiryItemRequest();
        $model->product = $entity->getProduct();
        $model->warehouseProduct = $entity->getWarehouseProduct();
        $model->price = $entity->getPrice();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
