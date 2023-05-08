<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\ProductImage;
use Impexta\Product\Domain\Entity\ProductImageInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ProductImage>
 * @method ProductImageInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImageInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ProductImageInterface> findAll()
 * @method array<ProductImageInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductImageRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImage::class);
    }
}
