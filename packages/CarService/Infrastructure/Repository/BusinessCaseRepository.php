<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<BusinessCase>
 * @method BusinessCaseInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessCaseInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<BusinessCaseInterface> findAll()
 * @method array<BusinessCaseInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BusinessCaseRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessCase::class);
    }
}
