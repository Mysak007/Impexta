<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class ShipmentState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const NEW = 'NEW';
    public const READY = 'READY';
    public const SHIPPED = 'SHIPPED';
    public const CANCELLED = 'CANCELLED';

    /** @return array<string, string> */
    public static function readables(): array
    {
        return [
            self::NEW => 'Nová',
            self::READY => 'Připravena',
            self::SHIPPED => 'Odeslána',
            self::CANCELLED => 'Zrušena',
        ];
    }
}
