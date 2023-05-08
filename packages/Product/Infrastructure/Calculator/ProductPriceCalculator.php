<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Calculator;

use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Enum\VatRate;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;

final class ProductPriceCalculator implements PriceCalculatorInterface
{
    /**
     * @param ProductInterface $product
     */
    public function getPriceWithoutVat($product, Currency $currency, ?ShopUserInterface $user): Money
    {
        $clientGroup = ClientGroup::get(ClientGroup::B2C);
        $sale = 0;

        if ($user !== null && $user->getClient() !== null) {
            $clientGroup = $user->getClient()->getClientGroup();
            $sale = $user->getClient()->getSale();
            $sale /= 100;
        }

        $productPrice = $product->getPrices()->filter(static function ($entityPrice) use ($currency, $clientGroup) {
            return ($entityPrice->getClientGroup() === $clientGroup) &&
                ($entityPrice->getPrice()->getCurrency()->getCode() === $currency->getCode());
        })->first();

        if (!$productPrice) {
            throw new PriceCalculatorException($product, $currency->getCode(), $user);
        }

        $price = $productPrice->getPrice();
        $price = $price->multiply(1 - $sale);

        return $price;
    }

    /**
     * @param ProductInterface $product
     */
    public function getPriceWithVat(
        $product,
        Currency $currency,
        ?ShopUserInterface $user
    ): Money {
        $vatRate = VatRate::getPercentage($product->getProductCard()->getVatRate());
        $vatRate /= 100;
        $price = $this->getPriceWithoutVat($product, $currency, $user);
        $price = $price->multiply(1 + $vatRate);

        return $price;
    }
}
