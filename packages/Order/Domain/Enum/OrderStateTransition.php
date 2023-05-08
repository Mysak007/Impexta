<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

final class OrderStateTransition
{
    public const CREATE = 'CREATE';
    public const CANCEL = 'CANCEL';
    public const COMPLETE = 'COMPLETE';
}
