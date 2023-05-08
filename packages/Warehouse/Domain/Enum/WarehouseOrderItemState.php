<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class WarehouseOrderItemState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const CREATED = 'CREATED';
    public const ORDERED = 'ORDERED';
    public const CANCELLED = 'CANCELLED';
    public const RECEIVED = 'RECEIVED';

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
        ];
    }
}
