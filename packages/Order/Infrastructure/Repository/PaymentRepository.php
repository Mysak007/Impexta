<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Order\Domain\Entity\Payment;
use Impexta\Order\Domain\Entity\PaymentInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Payment>
 * @method PaymentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<PaymentInterface> findAll()
 * @method array<PaymentInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PaymentRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }
}
