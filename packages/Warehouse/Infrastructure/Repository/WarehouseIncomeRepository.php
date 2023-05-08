<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Warehouse\Domain\Entity\WarehouseIncome;
use Impexta\Warehouse\Domain\Entity\WarehouseIncomeInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<WarehouseIncome>
 * @method WarehouseIncomeInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method WarehouseIncomeInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<WarehouseIncomeInterface> findAll()
 * @method array<WarehouseIncomeInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class WarehouseIncomeRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WarehouseIncome::class);
    }
}
