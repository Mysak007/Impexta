<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<Inquiry>
 * @method InquiryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method InquiryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<InquiryInterface> findAll()
 * @method array<InquiryInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class InquiryRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inquiry::class);
    }
}
