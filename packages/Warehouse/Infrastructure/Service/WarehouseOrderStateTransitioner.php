<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Service;

use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Infrastructure\Exception\TransitionNotAvailableException;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\Registry;

final class WarehouseOrderStateTransitioner
{
    private Registry $warehouseOrderWorkflow;

    public function __construct(Registry $warehouseOrderWorkflow)
    {
        $this->warehouseOrderWorkflow = $warehouseOrderWorkflow;
    }

    public function changeWarehouseOrderState(WarehouseOrder $warehouseOrder, string $transition): Marking
    {
        $workflow = $this->warehouseOrderWorkflow->get($warehouseOrder);

        if ($workflow->can($warehouseOrder, $transition)) {
            return $workflow->apply($warehouseOrder, $transition);
        }

        throw new TransitionNotAvailableException($warehouseOrder->getId(), $transition);
    }
}
