<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Domain\Entity\InquiryItemOffer;
use Impexta\Inquiry\Domain\Entity\InquiryItemOfferInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<InquiryItemOffer>
 * @method InquiryItemOfferInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method InquiryItemOfferInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<InquiryItemOfferInterface> findAll()
 * @method array<InquiryItemOfferInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class InquiryItemOfferRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InquiryItemOffer::class);
    }

    /**
     * @return array<InquiryItemOffer>
     */
    public function findItemOffersForInquiry(Inquiry $inquiry): ?array
    {
        return $this->createQueryBuilder('inquiryItemOffer')
            ->leftJoin('inquiryItemOffer.inquiryItemRequest', 'inquiryItemRequest')
            ->addSelect('inquiryItemRequest')
            ->addSelect('inquiryItemOffer')
            ->andWhere('inquiryItemRequest.inquiry = :inquiry')
            ->setParameter('inquiry', $inquiry)
            ->getQuery()
            ->getResult();
    }
}
