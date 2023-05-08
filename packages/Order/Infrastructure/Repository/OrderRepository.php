<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Order\Domain\Entity\Order;
use Impexta\Order\Domain\Entity\OrderInterface;
use Impexta\Order\Domain\Enum\OrderState;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Order>
 * @method OrderInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<OrderInterface> findAll()
 * @method array<OrderInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class OrderRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /** @return array<int, OrderInterface> */
    public function findAllOrderStatesWithoutCart(): array
    {
        return $this->createQueryBuilder('o')
            ->addSelect('o')
            ->andWhere('o.state != :state')
            ->setParameter('state', OrderState::CART)
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
