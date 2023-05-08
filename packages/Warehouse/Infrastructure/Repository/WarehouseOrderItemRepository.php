<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItem;
use Impexta\Warehouse\Domain\Entity\WarehouseOrderItemInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<WarehouseOrderItem>
 * @method WarehouseOrderItemInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseOrderItemInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<WarehouseOrderItemInterface> findAll()
 * @method array<WarehouseOrderItemInterface> findBy(array $criteria, array $orderBy=null, $limit=null, $offset=null)
 */
final class WarehouseOrderItemRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseOrderItem::class);
    }
}
