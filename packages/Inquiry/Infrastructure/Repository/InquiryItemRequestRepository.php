<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<InquiryItemRequest>
 * @method InquiryItemRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method InquiryItemRequestInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<InquiryItemRequestInterface> findAll()
 * @method array<InquiryItemRequestInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class InquiryItemRequestRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InquiryItemRequest::class);
    }
}
