<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\CarService\Domain\Entity\BusinessCaseVehicle;
use Impexta\CarService\Domain\Entity\BusinessCaseVehicleInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<BusinessCaseVehicle>
 * @method BusinessCaseVehicleInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessCaseVehicleInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<BusinessCaseVehicleInterface> findAll()
 * @method array<BusinessCaseVehicleInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BusinessCaseVehicleRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessCaseVehicle::class);
    }
}
