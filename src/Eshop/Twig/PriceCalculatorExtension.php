<?php

declare(strict_types=1);

namespace App\Eshop\Twig;

use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\Calculator\ProductPriceCalculator;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PriceCalculatorExtension extends AbstractExtension
{
    private ProductPriceCalculator $priceCalculator;

    public function __construct(
        ProductPriceCalculator $priceCalculator
    ) {
        $this->priceCalculator = $priceCalculator;
    }

    /** @return array<int,TwigFunction> */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('calculate_price', [$this, 'getCalculatedPrice']),
        ];
    }

    /**
     * @return array<string, int|Money|string>
     */
    public function getCalculatedPrice(ProductInterface $product, ?ShopUserInterface $user, string $currencyCode): array
    {
        $currency = new Currency($currencyCode);
        $clientType = 'B2C';

        if ($user !== null && $user->getClient()) {
            $clientType = $user->getClient()->getClientGroup()->getValue();
        }

        return [
            'withoutVat' => $this->priceCalculator->getPriceWithoutVat($product, $currency, $user),
            'withVat' => $this->priceCalculator->getPriceWithVat($product, $currency, $user),
            'clientType' => $clientType,
            'B2CPrice' => $this->priceCalculator->getPriceWithVat($product, $currency, null),
            'B2CPriceWithoutVat' => $this->priceCalculator->getPriceWithoutVat($product, $currency, null),
        ];
    }
}
