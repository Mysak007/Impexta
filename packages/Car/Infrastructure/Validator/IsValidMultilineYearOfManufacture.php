<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
final class IsValidMultilineYearOfManufacture extends Constraint
{
    public string $message = 'Neplatný rok. Rok výroby musí být vyšší než 1900. Více hodnot oddělte Enterem.';

    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }
}
