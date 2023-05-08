<?php

declare(strict_types=1);

namespace Impexta\User\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

/**
 * @method static UserRole get($value)
 * @method string getValue()
 */
final class UserRole extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const ROLE_CLIENT = 'ROLE_CLIENT';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::ROLE_CLIENT => 'Klient',
            self::ROLE_ADMIN => 'Administrátor',
            self::ROLE_SUPERADMIN => 'Hlavní administrátor',
        ];
    }
}
