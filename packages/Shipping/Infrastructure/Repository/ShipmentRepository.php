<?php

declare(strict_types=1);

namespace Impexta\Shipping\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Shipping\Domain\Entity\Shipment;
use Impexta\Shipping\Domain\Entity\ShipmentInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Shipment>
 * @method ShipmentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShipmentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ShipmentInterface> findAll()
 * @method array<ShipmentInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ShipmentRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shipment::class);
    }
}
