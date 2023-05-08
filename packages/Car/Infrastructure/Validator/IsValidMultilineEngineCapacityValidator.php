<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Validator;

use Impexta\Car\Presentation\Form\Model\CarModel;
use RuntimeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IsValidMultilineEngineCapacityValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidMultilineEngineCapacity) {
            throw new UnexpectedTypeException($constraint, IsValidMultilineEngineCapacity::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
        }

        $engines = preg_split(CarModel::ESCAPE_NEW_LINE_REGEX, $value);

        if (!$engines) {
            throw new RuntimeException();
        }

        foreach ($engines as $engine) {
            if (preg_match(CarModel::ENGINE_CAPACITY_MULTILINE_REGEX, $engine)) {
                continue;
            }

            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
