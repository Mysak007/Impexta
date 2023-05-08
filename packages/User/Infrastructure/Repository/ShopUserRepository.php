<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\User\Domain\Entity\ShopUser;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ShopUser>
 * @method ShopUserInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopUserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ShopUserInterface> findAll()
 * @method array<ShopUserInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ShopUserRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopUser::class);
    }

    public function findByEmail(string $email): bool
    {
        $query = $this->createQueryBuilder('shopUser')
            ->andWhere('shopUser.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        if ($query) {
            return true;
        }

        return false;
    }
}
