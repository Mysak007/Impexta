<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class Warehouse extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PRAGUE = 'PRAGUE';
    public const OSTRAVA = 'OSTRAVA';
    public const ZILINA = 'ZILINA';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::PRAGUE => 'Praha',
            self::OSTRAVA => 'Ostrava',
            self::ZILINA => 'Žilina',
        ];
    }
}
