<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class ClientGroup extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const B2B = 'B2B';
    public const B2C = 'B2C';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::B2B => 'Velkoobchod',
            self::B2C => 'Maloobchod',
        ];
    }
}
