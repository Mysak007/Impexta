<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Warehouse\Domain\Entity\WarehouseIssue;
use Impexta\Warehouse\Domain\Entity\WarehouseIssueInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<WarehouseIssue>
 * @method WarehouseIssueInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseIssueInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<WarehouseIssueInterface> findAll()
 * @method array<WarehouseIssueInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class WarehouseIssueRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseIssue::class);
    }

    /**
     * @return array<int, int>
     */
    public function findByWarehouse(Warehouse $warehouse): array
    {
        return $this->createQueryBuilder('warehouseIssue')
            ->andWhere('warehouseIssue.warehouse = :warehouse')
            ->setParameter('warehouse', $warehouse->getValue())
            ->getQuery()
            ->getResult();
    }
}
