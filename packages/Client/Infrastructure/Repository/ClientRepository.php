<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Client>
 * @method ClientInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ClientInterface> findAll()
 * @method array<ClientInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ClientRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /** @return Array<Client>|null */
    public function findClientsWithoutShopUser(?ShopUserInterface $shopUser): ?array
    {
        $query = $this->createQueryBuilder('client')
            ->leftJoin('client.shopUser', 'shopUser')
            ->andWhere('shopUser IS NULL');

        if ($shopUser) {
            $query->orWhere('shopUser = :user')
                ->setParameter('user', $shopUser);
        }

        return $query->getQuery()->getResult();
    }
}
