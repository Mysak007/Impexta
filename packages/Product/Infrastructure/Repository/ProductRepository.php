<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Presentation\Form\Model\FilterModel;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Product>
 * @method ProductInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ProductInterface> findAll()
 * @method array<ProductInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getQueryForProductsByCategory(Category $category, FilterModel $filterModel): Query
    {
        $queryBuilder = $this->createQueryBuilder('product')
            ->leftJoin('product.productCard', 'productCard')
            ->leftJoin('product.images', 'productImages')
            ->addSelect('productImages')
            ->leftJoin('product.warehouseProducts', 'warehouseProducts')
            ->addSelect('warehouseProducts')
            ->andWhere('productCard.category = :category')
            ->setParameter('category', $category)
            ->andWhere('product.showOnEshop = true');

        $queryBuilder = $this->addFilterCriteria($queryBuilder, $filterModel);

        return $queryBuilder->getQuery();
    }

    /**
     * @return Array<Product>|null
     */
    public function findLeastCountProductsForWarehouse(string $warehouse): ?array
    {
        return $this->createQueryBuilder('product')
            ->select('product as leastProduct')
            ->addSelect("COUNT(warehouseProducts.id) as warehouseProductCount")
            ->leftJoin(
                'product.warehouseProducts',
                'warehouseProducts',
                'WITH',
                'warehouseProducts.warehouse =:warehouse'
            )
            ->setParameter('warehouse', $warehouse)
            ->addSelect('product.leastInStock as productLeastInStock')
            ->having('warehouseProductCount <= productLeastInStock')
            ->groupBy('product.id')
            ->orderBy('warehouseProductCount', "DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Array<Product>
     */
    public function findProductsForEshop(?FilterModel $filterModel = null): ?array
    {
        $queryBuilder = $this->createQueryBuilder('product')
            ->leftJoin('product.images', 'productImages')
            ->addSelect('productImages')
            ->leftJoin('product.prices', 'productPrices')
            ->addSelect('productPrices')
            ->andWhere('product.showOnEshop = true');

        if ($filterModel) {
            $queryBuilder->leftJoin('product.productCard', 'productCard');
            $queryBuilder = $this->addFilterCriteria($queryBuilder, $filterModel);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function getQueryForProductsByParentCategory(Category $category, FilterModel $filterModel): Query
    {
        $queryBuilder = $this->createQueryBuilder('product')
            ->leftJoin('product.productCard', 'productCard')
            ->addSelect('productCard')
            ->leftJoin('productCard.category', 'productCardCategory')
            ->addSelect('productCardCategory')
            ->leftJoin('product.images', 'productImages')
            ->addSelect('productImages')
            ->leftJoin('product.warehouseProducts', 'warehouseProducts')
            ->addSelect('warehouseProducts')
            ->andWhere('productCardCategory.parent = :category')
            ->orWhere('productCard.category = :category')
            ->setParameter('category', $category);

        $queryBuilder = $this->addFilterCriteria($queryBuilder, $filterModel);

        return $queryBuilder->getQuery();
    }

    /**
     * @return Array<Product>
     */
    public function findRandomProductsForEshop(): ?array
    {
        return $this->createQueryBuilder('product')
            ->leftJoin('product.images', 'productImages')
            ->leftJoin('product.prices', 'productPrices')
            ->andWhere('product.showOnEshop = true')
            ->orderBy('RAND()')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Array<Product>|null
     */
    public function findAlternativeProductsForEshop(ProductCardInterface $productCard): ?array
    {
        return $this->createQueryBuilder('product')
            ->andWhere('product.productCard = :productCard')
            ->setParameter('productCard', $productCard)
            ->orderBy('RAND()')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function getQueryForProducts(?string $searchQuery = null): Query
    {
        $queryBuilder = $this->createQueryBuilder('product')
            ->leftJoin('product.productCard', 'productCard')
            ->leftJoin('product.images', 'productImages')
            ->addSelect('productImages')
            ->leftJoin('product.warehouseProducts', 'warehouseProducts')
            ->addSelect('warehouseProducts')
            ->andWhere('product.showOnEshop = true');

        if ($searchQuery) {
            $queryBuilder->andWhere('
                product.name LIKE :search OR
                productCard.name LIKE :search OR
                productCard.description LIKE :search OR
                productCard.note LIKE :search
            ')
                ->setParameter('search', '%' . $searchQuery . '%');
        }

        return $queryBuilder->getQuery();
    }

    public function addFilterCriteria(
        QueryBuilder $queryBuilder,
        FilterModel $filterModel
    ): QueryBuilder {
        if (
            $filterModel->manufacturer ||
            $filterModel->model ||
            $filterModel->yearOfManufacture ||
            $filterModel->engineCapacity
        ) {
            $queryBuilder
                ->leftJoin('productCard.cars', 'cars')
                ->leftJoin('cars.car', 'car');

            if ($filterModel->manufacturer) {
                $queryBuilder
                    ->andWhere('car.manufacturer = :manufacturer')
                    ->setParameter('manufacturer', $filterModel->manufacturer);
            }

            if ($filterModel->model) {
                $queryBuilder
                    ->andWhere('car.model = :model')
                    ->setParameter('model', $filterModel->model);
            }

            if ($filterModel->yearOfManufacture) {
                $queryBuilder
                    ->andWhere('car.yearOfManufacture = :yearOfManufacture')
                    ->setParameter('yearOfManufacture', $filterModel->yearOfManufacture);
            }

            if ($filterModel->engineCapacity) {
                $queryBuilder
                    ->andWhere('car.engineCapacity = :engineCapacity')
                    ->setParameter('engineCapacity', $filterModel->engineCapacity);
            }
        }

        return $queryBuilder;
    }
}
