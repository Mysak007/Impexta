<?php

declare(strict_types=1);

namespace App\CRM\Ares;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;
use Throwable;

final class AresException extends BaseException
{
    public function __construct(
        string $publicMessage,
        string $debugMessage,
        ?Throwable $previous = null
    ) {
        $exceptionContext = new ExceptionContext($publicMessage, $debugMessage, 500);

        parent::__construct($exceptionContext, $previous);
    }
}
