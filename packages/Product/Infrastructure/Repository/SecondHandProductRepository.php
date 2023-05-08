<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<SecondHandProduct>
 * @method SecondHandProductInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondHandProductInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<SecondHandProductInterface> findAll()
 * @method array<SecondHandProductInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SecondHandProductRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondHandProduct::class);
    }
}
