<?php

declare(strict_types=1);

namespace App\Eshop\Enum;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;

final class CurrencyNotFoundException extends BaseException
{
    public function __construct(
        string $country
    ) {
        $publicMessage = 'Nebyla nalezena měna pro zadanou hodnotu';
        $debugMessage = sprintf(
            'Could not find currency code for country "%s"',
            $country
        );
        $exceptionContext = new ExceptionContext($publicMessage, $debugMessage, 404);

        parent::__construct($exceptionContext);
    }
}
