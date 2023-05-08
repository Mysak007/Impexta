<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class VatRate extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const BASE = 'BASE';
    public const FIRST_LOWER = 'FIRST_LOWER';
    public const SECOND_LOWER = 'SECOND_LOWER';

    /**
     * @return array<string>
     */
    public static function readables(): array
    {
        return [
            self::BASE => '21 %',
            self::FIRST_LOWER => '15 %',
            self::SECOND_LOWER => '10 %',
        ];
    }

    public static function getPercentage(VatRate $vatRate): int
    {
        switch ($vatRate) {
            case self::FIRST_LOWER:
                return 15;

            case self::SECOND_LOWER:
                return 10;
        }

        return 21;
    }
}
