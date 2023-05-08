<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Impexta\ContactForm\Domain\Entity\ContactForm;
use Impexta\ContactForm\Domain\Entity\ContactFormInterface;
use Microshop\SymfonySurvivalKit\Doctrine\AbstractEntityRepository;

/**
 * @extends AbstractEntityRepository<ContactForm>
 * @method ContactFormInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactFormInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method array<ContactFormInterface> findAll()
 * @method array<ContactFormInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ContactFormRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactForm::class);
    }
}
