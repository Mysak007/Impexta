<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Enum;

final class WarehouseOrderStateTransition
{
    public const ORDER = 'ORDER';
    public const CANCEL = 'CANCEL';
    public const RECEIVE = 'RECEIVE';
    public const PARTIALLY_RECEIVE = 'PARTIALLY_RECEIVE';
    public const PARTIALLY_CANCEL = 'PARTIALLY_CANCEL';
}
