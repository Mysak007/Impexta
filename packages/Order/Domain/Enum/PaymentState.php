<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class PaymentState extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const NEW = 'NEW';
    public const PAID = 'PAID';
    public const CANCELLED = 'CANCELLED';
    public const FAILED = 'FAILED';

    /** @return array<string, string> */
    public static function readables(): array
    {
        return [
            self::NEW => 'Nová',
            self::PAID => 'Zaplacena',
            self::CANCELLED => 'Zrušena',
            self::FAILED => 'Selhala',
        ];
    }
}
