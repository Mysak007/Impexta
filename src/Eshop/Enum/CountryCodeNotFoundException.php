<?php

declare(strict_types=1);

namespace App\Eshop\Enum;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;

final class CountryCodeNotFoundException extends BaseException
{
    public function __construct(
        string $country
    ) {
        $publicMessage = 'Nebyl nalezen kód země pro zadanou hodnotu';
        $debugMessage = sprintf(
            'Could not find country code for country "%s"',
            $country
        );
        $exceptionContext = new ExceptionContext($publicMessage, $debugMessage, 404);

        parent::__construct($exceptionContext);
    }
}
