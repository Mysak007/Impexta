<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Shipping\Domain\Entity\ShippingMethodPricing;
use Impexta\Shipping\Domain\Entity\ShippingMethodPricingInterface;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ShippingMethodPricing>
 * @method ShippingMethodPricingInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingMethodPricingInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ShippingMethodPricingInterface> findAll()
 * @method array<ShippingMethodPricingInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ShippingMethodPricingRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingMethodPricing::class);
    }

    public function findByShippingMethodAndCurrencyCode(
        ShippingMethod $shippingMethod,
        string $currencyCode
    ): ?ShippingMethodPricingInterface {
        return $this->createQueryBuilder('shippingMethodPricing')
            ->andWhere('shippingMethodPricing.shippingMethod = :shippingMethod')
            ->setParameter('shippingMethod', $shippingMethod->getValue())
            ->andWhere('shippingMethodPricing.price.currency.code = :currencyCode')
            ->setParameter('currencyCode', $currencyCode)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
