<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Model;

use Impexta\Product\Domain\Enum\VatRate;
use Money\Currency;
use Money\Money;

final class XmlFeedProductPriceModel
{
    public Money $price;
    public VatRate $vat;
    public Money $priceWithVat;
    public Currency $currency;

    public function __construct(
        Money $price,
        VatRate $vat,
        Money $priceWithVat,
        Currency $currency
    ) {
        $this->price = $price;
        $this->vat = $vat;
        $this->priceWithVat = $priceWithVat;
        $this->currency = $currency;
    }
}
