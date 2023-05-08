<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderInterface;
use Impexta\Warehouse\Domain\Enum\WarehouseOrderState;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<WarehouseOrder>
 * @method WarehouseOrderInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseOrderInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<WarehouseOrderInterface> findAll()
 * @method array<WarehouseOrderInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class WarehouseOrderRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseOrder::class);
    }

    /**
     * @return array<int, string>
     */
    public function findOpenOrders(): array
    {
        return $this->findByState([
            WarehouseOrderState::CREATED,
            WarehouseOrderState::ORDERED,
            WarehouseOrderState::PARTIALLY_RECEIVED,
        ]);
    }

    /**
     * @return array<int, string>
     */
    public function findClosedOrders(): array
    {
        return $this->findByState([
            WarehouseOrderState::CANCELLED,
            WarehouseOrderState::RECEIVED,
            WarehouseOrderState::PARTIALLY_CANCELLED,
        ]);
    }

    /**
     * @param array<int, string> $states
     * @return array<int, string>
     */
    private function findByState(array $states): array
    {
        return $this->createQueryBuilder('warehouse_order')
            ->andWhere('warehouse_order.state IN (:states)')
            ->setParameter('states', $states)
            ->getQuery()
            ->getResult();
    }
}
