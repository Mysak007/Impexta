<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\CarService\Domain\Entity\BusinessCaseImage;
use Impexta\CarService\Domain\Entity\BusinessCaseImageInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<BusinessCaseImage>
 * @method BusinessCaseImageInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessCaseImageInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<BusinessCaseImageInterface> findAll()
 * @method array<BusinessCaseImageInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BusinessCaseImageRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessCaseImage::class);
    }
}
