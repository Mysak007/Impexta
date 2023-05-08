<?php

declare(strict_types=1);

namespace Impexta\Car\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Car\Domain\Entity\Car;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Car\Domain\Entity\CarManufacturerInterface;
use Impexta\Product\Presentation\Form\Model\FilterModel;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Car>
 * @method CarInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<CarInterface> findAll()
 * @method array<CarInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CarRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * @return array<int, string>
     */
    public function findUniqueModelsByManufacturer(CarManufacturerInterface $carManufacturer): array
    {
        $result = $this->createQueryBuilder('car')
            ->select('car.model')
            ->where('car.manufacturer = :manufacturer')
            ->setParameter('manufacturer', $carManufacturer)
            ->groupBy('car.model')
            ->getQuery()
            ->getScalarResult();

        return array_column($result, 'model');
    }

    /** @return array<int, string> */
    public function loadByManufacturerForEshop(CarManufacturerInterface $carManufacturer): array
    {
        return $this->createQueryBuilder('car')
            ->leftJoin('car.manufacturer', 'car_manufacturer')
            ->where('car.manufacturer = :manufacturer')
            ->setParameter('manufacturer', $carManufacturer)
            ->andWhere('car_manufacturer.showOnEshop = true')
            ->andWhere('car.hideOnEshop = false')
            ->getQuery()
            ->getResult();
    }

    /** @return array<int, Car> */
    public function findByCriteria(FilterModel $filterModel): array
    {
        $queryBuilder = $this->createQueryBuilder('car')
            ->andWhere('car.manufacturer = :manufacturer')
            ->setParameter('manufacturer', $filterModel->manufacturer);

        if ($filterModel->model) {
            $queryBuilder->andWhere('car.model = :model')
                ->setParameter('model', $filterModel->model);
        }

        if ($filterModel->yearOfManufacture) {
            $queryBuilder->andWhere('car.yearOfManufacture = :yearOfManufacture')
                ->setParameter('yearOfManufacture', $filterModel->yearOfManufacture);
        }

        if ($filterModel->engineCapacity) {
            $queryBuilder->andWhere('car.engineCapacity = :engineCapacity')
                ->setParameter('engineCapacity', $filterModel->engineCapacity);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
