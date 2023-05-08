<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Order\Domain\Entity\OrderItem;
use Impexta\Order\Domain\Entity\OrderItemInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<OrderItem>
 * @method OrderItemInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderItemInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<OrderItemInterface> findAll()
 * @method array<OrderItemInterface> findBy(array $criteria,array $orderBy = null,$limit = null,$offset = null)
 */
final class OrderItemRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }
}
