<?php

declare(strict_types=1);

namespace App\Eshop\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class PhoneNumberExtension extends AbstractExtension
{
    /** @see https://regex101.com/r/0vd7oZ/1 */
    private const PHONE_REGEX = "/(\+42\d)(\d{3})(\d{3})(\d{3})/";

    /** @see https://regex101.com/r/aOt9mg/1 */
    private const LANDLINE_REGEX = "/(\d{3})(\d{3})(\d{3})/";

    /** @return array<int,TwigFilter> */
    public function getFilters(): array
    {
        return [
            new TwigFilter('phoneNumber', [$this, 'phoneFilter']),
        ];
    }

    public function phoneFilter(string $phoneNumber): ?string
    {
        if (substr($phoneNumber, 0, 2) === "+4") {
            return preg_replace(self::PHONE_REGEX, "$1 $2 $3 $4", $phoneNumber);
        }

        return preg_replace(self::LANDLINE_REGEX, "$1 $2 $3", $phoneNumber);
    }
}
