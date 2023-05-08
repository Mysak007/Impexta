<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Model;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class WarehouseProductModel implements ModelInterface
{
    /** @Assert\NotBlank(message="Musí být vybrán produkt") */
    public Product $product;

    /** @Assert\NotBlank(message="Musí být vyplněna cena") */
    public Money $purchasePrice;

    /** @param WarehouseProductInterface $entity */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $warehouseProductModel = self::createEmpty();
        $warehouseProductModel->product = $entity->getProduct();
        $warehouseProductModel->purchasePrice = $entity->getPurchasePrice();

        return $warehouseProductModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
