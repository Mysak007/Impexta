<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
final class IsValidMultilineEngineCapacity extends Constraint
{
    public string $message =
        'Objem motoru musí být desetinné číslo. Více hodnot oddělte Enterem.'
    ;

    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }
}
