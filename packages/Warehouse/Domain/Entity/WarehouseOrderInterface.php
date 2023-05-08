<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface WarehouseOrderInterface extends EntityInterface
{
    public function getWarehouse(): Warehouse;

    public function setWarehouse(Warehouse $warehouse): void;

    public function getState(): string;

    public function setState(string $state): void;

    /** @return Collection<int, WarehouseOrderItemInterface> */
    public function getOrderItems(): Collection;

    /** @return Collection<int, WarehouseOrderItemInterface> */
    public function getReceivedOrderItems(): Collection;

    public function addItem(WarehouseOrderItemInterface $warehouseOrderItem): void;

    public function removeOrderItem(WarehouseOrderItemInterface $warehouseOrderItem): void;

    /** @param ArrayCollection<int, WarehouseOrderItemInterface> $warehouseOrderItems */
    public function setWarehouseOrderItem(ArrayCollection $warehouseOrderItems): void;

    public function getCreator(): AdminUserInterface;
}
