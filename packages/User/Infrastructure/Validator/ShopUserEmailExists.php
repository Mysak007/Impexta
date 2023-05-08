<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class ShopUserEmailExists extends Constraint
{
    public string $message = 'Uživatel s e-mailem {{ string }} již existuje. Zvolte jiný e-mail.';
}
