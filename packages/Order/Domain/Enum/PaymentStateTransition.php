<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Enum;

final class PaymentStateTransition
{
    public const CANCEL = 'CANCEL';
    public const PAY = 'PAY';
    public const FAIL = 'FAIL';
}
