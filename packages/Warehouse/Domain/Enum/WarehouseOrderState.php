<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

/**
 * @method string getValue()
 */
final class WarehouseOrderState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const CREATED = 'CREATED';
    public const ORDERED = 'ORDERED';
    public const CANCELLED = 'CANCELLED';
    public const RECEIVED = 'RECEIVED';
    public const PARTIALLY_RECEIVED = 'PARTIALLY_RECEIVED';
    public const PARTIALLY_CANCELLED = 'PARTIALLY_CANCELLED';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::CREATED => 'Vytvořeno',
            self::ORDERED => 'Objednáno',
            self::CANCELLED => 'Zrušeno',
            self::RECEIVED => 'Přijato',
            self::PARTIALLY_RECEIVED => 'Částečně přijato',
            self::PARTIALLY_CANCELLED => 'Částečně zrušeno',
        ];
    }
}
