<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Model;

use DateTimeImmutable;
use Impexta\Store\Domain\Entity\StoreInterface;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHoursInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreSpecialOpeningHoursModel implements ModelInterface
{
    public ?int $id = null;

    /** @Assert\Valid */
    public StoreInterface $store;

    /** @Assert\Valid */
    public DateTimeImmutable $day;
    public bool $open;

    /** @Assert\Valid */
    public ?DateTimeImmutable $opensAt;

    /** @Assert\Valid */
    public ?DateTimeImmutable $closesAt;

    /** @param StoreSpecialOpeningHoursInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $specialOpeningHours = self::createEmpty();
        $specialOpeningHours->id = $entity->getId();
        $specialOpeningHours->store = $entity->getStore();
        $specialOpeningHours->day = $entity->getDay();
        $specialOpeningHours->open = $entity->isOpen();
        $specialOpeningHours->opensAt = $entity->getOpensAt();
        $specialOpeningHours->closesAt = $entity->getClosesAt();

        return $specialOpeningHours;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
