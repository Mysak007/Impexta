<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\CarService\Domain\Entity\BusinessCaseFile;
use Impexta\CarService\Domain\Entity\BusinessCaseFileInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<BusinessCaseFile>
 * @method BusinessCaseFileInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessCaseFileInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<BusinessCaseFileInterface> findAll()
 * @method array<BusinessCaseFileInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BusinessCaseFileRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessCaseFile::class);
    }
}
