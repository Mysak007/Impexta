<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Enum;

use Elao\Enum\AutoDiscoveredValuesTrait;
use Elao\Enum\ReadableEnum;

final class ShippingMethod extends ReadableEnum
{
    use AutoDiscoveredValuesTrait;

    public const PICK_UP = 'PICK_UP';
    public const DELIVERY = 'DELIVERY';
    public const DELIVERY_EXPRESS = 'DELIVERY_EXPRESS';

    /**
     * @return array<string, string>
     */
    public static function readables(): array
    {
        return [
            self::PICK_UP => 'Vyzvednutí',
            self::DELIVERY => 'Doručení',
            self::DELIVERY_EXPRESS => 'Expresní doručení',
        ];
    }
}
