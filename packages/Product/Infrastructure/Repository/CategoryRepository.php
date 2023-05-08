<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Impexta\Product\Domain\Entity\Product;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Category>
 * @method CategoryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<CategoryInterface> findAll()
 * @method array<CategoryInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CategoryRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /** @return array<int, string> */
    public function findAllCategoriesWithoutParent(): array
    {
        return $this->createQueryBuilder('category')
            ->andWhere('category.parent IS NULL')
            ->orderBy('category.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Array<Product>|null
     */
    public function findCategoriesWithSubcategoryCount(?int $parentCategory = null): ?array
    {
        $builder = $this->createQueryBuilder('category')
            ->select('category as categoryName')
            ->leftJoin('category.children', 'children')
            ->addSelect('COUNT(children.id) as childrenCount')
            ->groupBy('category.id')
            ->orderBy('category.position');

        if ($parentCategory === null) {
            $builder->andWhere('category.parent IS NULL');
        }

        if ($parentCategory !== null) {
            $builder->andWhere('category.parent = :parentCategory')
                ->setParameter('parentCategory', $parentCategory);
        }

        return $builder->getQuery()->getResult();
    }
}
