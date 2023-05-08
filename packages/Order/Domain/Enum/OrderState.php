<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class OrderState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const CART = 'CART';
    public const NEW = 'NEW';
    public const COMPLETED = 'COMPLETED';
    public const CANCELLED = 'CANCELLED';

    /** @return array<int, string> */
    public static function values(): array
    {
        return [
            self::CART,
            self::NEW,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }

    /** @return array<string, string> */
    public static function readables(): array
    {
        return [
            self::CART => 'V košíku',
            self::NEW => 'Nová',
            self::COMPLETED => 'Dokončená',
            self::CANCELLED => 'Zrušená',
        ];
    }
}
