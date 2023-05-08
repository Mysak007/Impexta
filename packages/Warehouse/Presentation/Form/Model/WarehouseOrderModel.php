<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class WarehouseOrderModel implements ModelInterface
{
    public Warehouse $warehouse;

    /** @Assert\NotBlank(message="Stav objednávky nesmí být prázdný") */
    public WarehouseOrderState $state;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, WarehouseOrderItemModel>
     */
    public Collection $warehouseOrderItems;

    public function __construct()
    {
        $this->warehouseOrderItems = new ArrayCollection();
        $this->state = WarehouseOrderState::get(WarehouseOrderState::CREATED);
    }

    /**
     * @param WarehouseOrderInterface $entity
     * @return WarehouseOrderModel
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $warehouseOrderModel = new self();
        $warehouseOrderModel->warehouse = $entity->getWarehouse();
        $warehouseOrderModel->state = WarehouseOrderState::get($warehouseOrderModel->state->getValue());
        $warehouseOrderModel->warehouseOrderItems = new ArrayCollection();

        foreach ($entity->getOrderItems() as $warehouseOrderItem) {
            $warehouseOrderModel->warehouseOrderItems[] = WarehouseOrderItemModel::createFromEntity(
                $warehouseOrderItem
            );
        }

        return $warehouseOrderModel;
    }

    /**
     * @return WarehouseOrderModel
     */
    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
