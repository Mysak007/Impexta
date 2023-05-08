<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderItemState;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class WarehouseOrder implements WarehouseOrderInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private Warehouse $warehouse;
    private WarehouseOrderState $state;
    private AdminUserInterface $creator;

    /** @var ArrayCollection<int, WarehouseOrderItemInterface> $orderItems */
    private Collection $orderItems;

    public function __construct(
        Warehouse $warehouse,
        AdminUserInterface $adminUser
    ) {
        $this->warehouse = $warehouse;
        $this->state = WarehouseOrderState::get(WarehouseOrderState::CREATED);
        $this->orderItems = new ArrayCollection();
        $this->creator = $adminUser;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    public function getState(): string
    {
        return $this->state->getValue();
    }

    public function getStateReadable(): string
    {
        return $this->state->getReadable();
    }

    public function setState(string $state): void
    {
        $this->state = WarehouseOrderState::get($state);
    }

    /**
     * @return Collection<int, WarehouseOrderItemInterface>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * @return Collection<int, WarehouseOrderItemInterface>
     */
    public function getReceivedOrderItems(): Collection
    {
        return $this->getOrderItems()->filter(static function (WarehouseOrderItemInterface $warehouseOrderItem) {
            return $warehouseOrderItem->getState()->getValue() === WarehouseOrderItemState::RECEIVED;
        });
    }

    public function addItem(WarehouseOrderItemInterface $warehouseOrderItem): void
    {
        $this->orderItems[] = $warehouseOrderItem;
    }

    public function removeOrderItem(WarehouseOrderItemInterface $warehouseOrderItem): void
    {
        $this->orderItems->removeElement($warehouseOrderItem);
    }

    /** @param ArrayCollection<int, WarehouseOrderItemInterface> $warehouseOrderItems */
    public function setWarehouseOrderItem(ArrayCollection $warehouseOrderItems): void
    {
        $this->orderItems = $warehouseOrderItems;
    }

    public function getCreator(): AdminUserInterface
    {
        return $this->creator;
    }
}
