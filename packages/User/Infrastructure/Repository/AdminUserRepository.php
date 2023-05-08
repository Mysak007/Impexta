<?php

declare(strict_types=1);

namespace Impexta\User\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\User\Domain\Entity\AdminUser;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<AdminUser>
 * @method AdminUserInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminUserInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<AdminUserInterface> findAll()
 * @method array<AdminUserInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AdminUserRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }
}
