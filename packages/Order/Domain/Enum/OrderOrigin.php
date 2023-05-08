<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class OrderOrigin extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const CRM = 'CRM';
    public const ESHOP = 'ESHOP';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::CRM => 'CRM',
            self::ESHOP => 'ESHOP',
        ];
    }
}
