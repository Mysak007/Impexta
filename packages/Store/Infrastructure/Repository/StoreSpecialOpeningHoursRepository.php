<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHoursInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<StoreSpecialOpeningHours>
 * @method StoreSpecialOpeningHoursInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreSpecialOpeningHoursInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<StoreSpecialOpeningHoursInterface> findAll()
 * @method array<StoreSpecialOpeningHoursInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class StoreSpecialOpeningHoursRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreSpecialOpeningHours::class);
    }
}
