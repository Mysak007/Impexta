<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Client\Domain\Entity\ClientCar;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ClientCar>
 * @method ClientCarInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientCarInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ClientCarInterface> findAll()
 * @method array<ClientCarInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ClientCarRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientCar::class);
    }
}
