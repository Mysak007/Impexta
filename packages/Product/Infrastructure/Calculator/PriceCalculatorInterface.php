<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Calculator;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;

interface PriceCalculatorInterface
{
    /** @param ProductInterface|SecondHandProductInterface $product */
    public function getPriceWithoutVat($product, Currency $currency, ?ShopUserInterface $user): Money;

    /** @param ProductInterface|SecondHandProductInterface $product */
    public function getPriceWithVat($product, Currency $currency, ?ShopUserInterface $user): Money;
}
