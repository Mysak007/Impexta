<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Calculator;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\User\Domain\Entity\ShopUserInterface;

final class PriceCalculatorException extends BaseException
{
    public function __construct(
        ProductInterface $product,
        string $currency,
        ?ShopUserInterface $user
    ) {
        $publicMessage = 'Pro vybranou zemi není specifikována měna.';
        $debugMessage = sprintf(
            'Could not find price for product id "%s", currency "%s" and user id "%s"',
            $product->getId(),
            $currency,
            $user ? $user->getId() : 'NULL'
        );
        $exceptionContext = new ExceptionContext($publicMessage, $debugMessage, 404);

        parent::__construct($exceptionContext);
    }
}
