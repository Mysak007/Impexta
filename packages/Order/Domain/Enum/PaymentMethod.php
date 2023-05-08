<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class PaymentMethod extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const TRANSFER = 'TRANSFER';
    public const ONLINE = 'ONLINE';
    public const CASH = 'CASH';

    /** @return array<string, string> */
    public static function readables(): array
    {
        return [
            self::TRANSFER => 'Převodem',
            self::ONLINE => 'Online',
            self::CASH => 'V hotovosti',
        ];
    }
}
