<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Exception;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;

final class TransitionNotAvailableException extends BaseException
{
    public function __construct(int $warehouseOrder, string $transition)
    {
        $exceptionContext = new ExceptionContext(
            'Při pokusu o změnu stavu došlo k chybě, zkuste to prosím později',
            sprintf('Warehouse Order with id "%s" cannot do transition "%s"', $warehouseOrder, $transition),
            500
        );

        parent::__construct($exceptionContext);
    }
}
