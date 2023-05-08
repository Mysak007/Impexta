<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Car\Domain\Entity\CarManufacturer;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<CarManufacturer>
 * @method CarManufacturer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarManufacturer|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<CarManufacturer> findAll()
 * @method array<CarManufacturer> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CarManufacturerRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarManufacturer::class);
    }

    /** @return array<int,string> */
    public function getIdAndNameAsAssociativeArray(): array
    {
        $result = $this->createQueryBuilder('car_manufacturer')
            ->select('car_manufacturer.id, car_manufacturer.name')
            ->orderBy('car_manufacturer.name', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return array_column($result, 'name', 'id');
    }

    /** @return array<int,string> */
    public function findForEshop(): array
    {
        return $this->createQueryBuilder('car_manufacturer')
            ->where('car_manufacturer.showOnEshop = true')
            ->getQuery()
            ->getResult();
    }
}
