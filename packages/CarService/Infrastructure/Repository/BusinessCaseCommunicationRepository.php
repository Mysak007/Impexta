<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunication;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunicationInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<BusinessCaseCommunication>
 * @method BusinessCaseCommunicationInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessCaseCommunicationInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<BusinessCaseCommunicationInterface> findAll()
 * @method array<BusinessCaseCommunicationInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BusinessCaseCommunicationRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessCaseCommunication::class);
    }
}
