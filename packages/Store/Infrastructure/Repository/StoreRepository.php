<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Entity\StoreInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Store>
 * @method StoreInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<StoreInterface> findAll()
 * @method array<StoreInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class StoreRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }
}
