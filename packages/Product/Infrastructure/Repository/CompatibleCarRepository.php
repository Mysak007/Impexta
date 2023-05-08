<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\CompatibleCar;
use Impexta\Product\Domain\Entity\CompatibleCarInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<CompatibleCar>
 * @method CompatibleCarInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompatibleCarInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<CompatibleCarInterface> findAll()
 * @method array<CompatibleCarInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CompatibleCarRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompatibleCar::class);
    }
}
