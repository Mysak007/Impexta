<?php

declare(strict_types=1);

namespace Impexta\Cart\Api\Model;

use JMS\Serializer\Annotation\Type;
use Money\Money;

final class ProductModel
{
    /** @Type("integer") */
    public int $productId;

    /** @Type("integer") */
    public int $quantity;

    /** @Type("string") */
    public string $name;

    /** @Type("Money\Money") */
    public Money $unitPrice;

    /** @Type("Money\Money") */
    public Money $totalPrice;

    /** @Type("string") */
    public string $mainImage;

    public function __construct(
        int $productId,
        int $quantity,
        string $name,
        Money $unitPrice,
        Money $totalPrice,
        string $mainImage
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->totalPrice = $totalPrice;
        $this->mainImage = $mainImage;
    }
}
