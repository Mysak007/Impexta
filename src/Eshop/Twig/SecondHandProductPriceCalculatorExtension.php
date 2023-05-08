<?php

declare(strict_types=1);

namespace App\Eshop\Twig;

use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\Product\Infrastructure\Calculator\SecondHandProductPriceCalculator;
use Money\Currency;
use Money\Money;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SecondHandProductPriceCalculatorExtension extends AbstractExtension
{
    private SecondHandProductPriceCalculator $productPriceCalculator;

    public function __construct(SecondHandProductPriceCalculator $productPriceCalculator)
    {
        $this->productPriceCalculator = $productPriceCalculator;
    }

    /** @return array<int,TwigFunction> */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('calculate_second_hand_product_price', [$this, 'getCalculatedPrice']),
        ];
    }

    /**
     * @return array<string, Money|string>
     */
    public function getCalculatedPrice(SecondHandProductInterface $product): array
    {
        $currency = new Currency('CZK');

        return [
            'withoutVat' => $this->productPriceCalculator->getPriceWithoutVat($product, $currency, null),
            'withVat' => $this->productPriceCalculator->getPriceWithVat($product, $currency, null),
            'B2CPrice' => $this->productPriceCalculator->getPriceWithVat($product, $currency, null),
        ];
    }
}
