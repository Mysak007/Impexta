<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Category>
 * @method CategoryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<CategoryInterface> findAll()
 * @method array<CategoryInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductCategoryRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
}
