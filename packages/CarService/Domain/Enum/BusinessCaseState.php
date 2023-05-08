<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class BusinessCaseState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PLANNED = 'PLANNED';
    public const OPEN = 'OPEN';
    public const IN_PROGRESS = 'IN_PROGRESS';
    public const FINISHED = 'FINISHED';
    public const CANCELLED = 'CANCELLED';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::PLANNED => 'Naplánová',
            self::OPEN => 'Otevřená',
            self::IN_PROGRESS => 'Zpracovává se',
            self::FINISHED => 'Ukončená',
            self::CANCELLED => 'Zrušená',
        ];
    }
}
