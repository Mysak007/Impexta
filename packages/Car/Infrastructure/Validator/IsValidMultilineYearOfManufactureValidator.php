<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Validator;

use Impexta\Car\Presentation\Form\Model\CarModel;
use RuntimeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

final class IsValidMultilineYearOfManufactureValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidMultilineYearOfManufacture) {
            throw new UnexpectedTypeException($constraint, IsValidMultilineYearOfManufacture::class);
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

        $years = preg_split(CarModel::ESCAPE_NEW_LINE_REGEX, $value);

        if (!$years) {
            throw new RuntimeException();
        }

        foreach ($years as $year) {
            if (preg_match(CarModel::YEAR_OF_MANUFACTURE_MULTILINE_REGEX, $year)) {
                continue;
            }

            // the argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
