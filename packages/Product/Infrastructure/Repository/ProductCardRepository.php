<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ProductCard>
 * @method ProductCardInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCardInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ProductCardInterface> findAll()
 * @method array<ProductCardInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductCardRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCard::class);
    }
}
