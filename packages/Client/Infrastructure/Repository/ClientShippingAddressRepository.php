<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ClientShippingAddress>
 * @method ClientShippingAddressInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientShippingAddressInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ClientShippingAddressInterface> findAll()
 * @method array<ClientShippingAddressInterface>findBy(array$criteria,array$orderBy=null,$limit=null,$offset=null)
 */
final class ClientShippingAddressRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientShippingAddress::class);
    }
}
