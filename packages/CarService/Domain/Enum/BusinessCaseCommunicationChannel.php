<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class BusinessCaseCommunicationChannel extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PHONE = 'PHONE';
    public const EMAIL = 'EMAIL';
    public const IN_PERSON = 'IN_PERSON';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::PHONE => 'Telefonicky',
            self::EMAIL => 'E-mailem',
            self::IN_PERSON => 'Osobně',
        ];
    }
}
