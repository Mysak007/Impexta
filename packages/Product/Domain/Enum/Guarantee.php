<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class Guarantee extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const YEAR = 'YEAR';
    public const TWO_YEARS = 'TWO_YEARS';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::YEAR => '1 rok',
            self::TWO_YEARS => '2 roky',
        ];
    }
}
