<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Calculator;

use holicz\SimpleException\BaseException;
use holicz\SimpleException\ExceptionContext;
use Impexta\Order\Domain\Entity\OrderInterface;

final class ShipmentPriceCalculatorException extends BaseException
{
    public function __construct(
        OrderInterface $order
    ) {
        parent::__construct(new ExceptionContext(
            'Při výpočtu ceny dopravy došlo k chybě. Zkuste to prosím později.',
            sprintf(
                'Cannot calculate price for shipping id "%s" with method "%s"',
                $order->getShipment()->getId(),
                $order->getShipment()->getShippingMethod()->getValue(),
            ),
            404
        ));
    }
}
