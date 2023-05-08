<?php

declare(strict_types=1);

namespace Impexta\Car\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class CarCategory extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PERSONAL = 'PERSONAL';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::PERSONAL => 'Osobní',
        ];
    }
}
