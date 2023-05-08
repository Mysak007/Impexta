<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Domain\Entity\ProductPrice;
use Impexta\Product\Domain\Entity\ProductPriceInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;
use Money\Currency;

/**
 * @extends AbstractEntityRepository<ProductPrice>
 * @method ProductPriceInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductPriceInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ProductPriceInterface> findAll()
 * @method array<ProductPriceInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductPriceRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPrice::class);
    }

    public function findPriceForProductAndClientGroup(
        ProductInterface $product,
        Currency $currency,
        ?ClientGroup $clientGroup
    ): ?ProductPrice {
        $query = $this->createQueryBuilder('productPrice')
            ->andWhere('productPrice.product = :product')
            ->setParameter('product', $product)
            ->andWhere('productPrice.price.currency.code = :currency')
            ->setParameter('currency', $currency->getCode());

        if ($clientGroup) {
            $query->andWhere('productPrice.clientGroup = :clientGroup')
                ->setParameter('clientGroup', $clientGroup->getValue());
        }

        if (!$clientGroup) {
            $query->andWhere('productPrice.clientGroup IS NULL');
        }

        return $query->getQuery()->getOneOrNullResult();
    }
}
