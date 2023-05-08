<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Model;

use DateTimeImmutable;
use Impexta\Store\Domain\Entity\StoreInterface;
use Impexta\Store\Domain\Entity\StoreOpeningHoursInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreOpeningHoursModel implements ModelInterface
{
    public ?int $id = null;

    /** @Assert\Valid */
    public StoreInterface $store;

    /**
     * @Assert\Valid
     * @Assert\Range(min="1",max="7")
     */
    public int $day;
    public bool $open;

    /** @Assert\Valid */
    public ?DateTimeImmutable $opensAt;

    /** @Assert\Valid */
    public ?DateTimeImmutable $closesAt;

    /** @param StoreOpeningHoursInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $openingHours = self::createEmpty();
        $openingHours->id = $entity->getId();
        $openingHours->store = $entity->getStore();
        $openingHours->day = $entity->getDay();
        $openingHours->open = $entity->isOpen();
        $openingHours->opensAt = $entity->getOpensAt();
        $openingHours->closesAt = $entity->getClosesAt();

        return $openingHours;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
