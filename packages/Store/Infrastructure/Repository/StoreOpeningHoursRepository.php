<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Store\Domain\Entity\StoreOpeningHours;
use Impexta\Store\Domain\Entity\StoreOpeningHoursInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<StoreOpeningHours>
 * @method StoreOpeningHoursInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreOpeningHoursInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<StoreOpeningHoursInterface> findAll()
 * @method array<StoreOpeningHoursInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class StoreOpeningHoursRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreOpeningHours::class);
    }
}
