<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Warehouse\Domain\Entity\WarehouseProduct;
use Impexta\Warehouse\Domain\Entity\WarehouseProductInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<WarehouseProduct>
 * @method WarehouseProductInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseProductInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<WarehouseProductInterface> findAll()
 * @method array<WarehouseProductInterface> findBy(array $criteria,array $orderBy = null,$limit = null,$offset = null)
 */
final class WarehouseProductRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseProduct::class);
    }

    /**
     * @return array<int, int>
     */
    public function getWarehouseProductsWithOnStockQuantity(Warehouse $warehouse): array
    {
        return $this->createQueryBuilder('warehouseProduct')
            ->leftJoin('warehouseProduct.product', 'product')
            ->select('warehouseProduct AS warehouse_product')
            ->addSelect('count(warehouseProduct.product) AS on_stock')
            ->addSelect('product')
            ->andWhere('warehouseProduct.warehouse = :warehouse')
            ->setParameter('warehouse', $warehouse->getValue())
            ->groupBy('warehouseProduct.product')
            ->getQuery()
            ->getResult();
    }
}
