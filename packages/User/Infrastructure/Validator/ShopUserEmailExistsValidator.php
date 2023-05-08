<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Validator;

use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ShopUserEmailExistsValidator extends ConstraintValidator
{
    private ShopUserRepository $shopUserRepository;

    public function __construct(ShopUserRepository $shopUserRepository)
    {
        $this->shopUserRepository = $shopUserRepository;
    }

    /** @param ShopUserEmailExists $constraint */
    public function validate($value, Constraint $constraint): void
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!$this->shopUserRepository->findByEmail($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
