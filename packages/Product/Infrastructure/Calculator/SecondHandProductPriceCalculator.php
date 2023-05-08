<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Calculator;

use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\Product\Domain\Enum\VatRate;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;

final class SecondHandProductPriceCalculator implements PriceCalculatorInterface
{
    /**
     * @param SecondHandProductInterface $product
     */
    public function getPriceWithoutVat(
        $product,
        Currency $currency,
        ?ShopUserInterface $user
    ): Money {

        $vatRate = VatRate::getPercentage($product->getVatRate());
        $price = $product->getPrice();
        $vatAmount = $price->getAmount() / 100 * $vatRate;

        return $price->subtract(new Money((int)$vatAmount, $currency));
    }

    /**
     * @param SecondHandProductInterface $product
     */
    public function getPriceWithVat(
        $product,
        Currency $currency,
        ?ShopUserInterface $user
    ): Money {
        return $product->getPrice();
    }
}
