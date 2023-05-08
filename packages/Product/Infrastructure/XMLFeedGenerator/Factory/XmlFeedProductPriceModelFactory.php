<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Factory;

use App\Eshop\Enum\Country;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\Calculator\PriceCalculatorException;
use Impexta\Product\Infrastructure\Calculator\ProductPriceCalculator;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedProductPriceModel;
use Money\Currency;

final class XmlFeedProductPriceModelFactory
{
    private ProductPriceCalculator $priceCalculator;

    public function __construct(ProductPriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    /** @return array<int,XmlFeedProductPriceModel> */
    public function create(ProductInterface $product): array
    {
        $prices = [];

        foreach (Country::values() as $country) {
            try {
                $priceWithoutVat = $this->priceCalculator->getPriceWithoutVat(
                    $product,
                    new Currency(Country::getCurrency(Country::get($country))),
                    null
                );
            } catch (PriceCalculatorException $exception) {
                continue;
            }

            $currency = new Currency(Country::getCurrency(Country::get($country)));
            $prices[] = new XmlFeedProductPriceModel(
                $priceWithoutVat,
                $product->getProductCard()->getVatRate(),
                $this->priceCalculator->getPriceWithVat(
                    $product,
                    new Currency('CZK'),
                    null
                ),
                $currency
            );
        }

        return $prices;
    }
}
