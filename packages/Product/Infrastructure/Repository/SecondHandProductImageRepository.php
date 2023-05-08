<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\SecondHandProductImage;
use Impexta\Product\Domain\Entity\SecondHandProductImageInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<SecondHandProductImage>
 * @method SecondHandProductImageInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondHandProductImageInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<SecondHandProductImageInterface> findAll()
 * @method array<SecondHandProductImageInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SecondHandProductImageRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondHandProductImage::class);
    }
}
