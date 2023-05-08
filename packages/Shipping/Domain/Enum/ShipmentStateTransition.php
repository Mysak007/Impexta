<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Enum;

final class ShipmentStateTransition
{
    public const PREPARE = 'PREPARE';
    public const CANCEL = 'CANCEL';
    public const SHIP = 'SHIP';
}
