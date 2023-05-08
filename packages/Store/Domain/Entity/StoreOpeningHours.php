<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DateTimeImmutable;
use Impexta\Store\Presentation\Form\Model\StoreOpeningHoursModel;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class StoreOpeningHours implements StoreOpeningHoursInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private StoreInterface $store;
    private int $day;
    private bool $open;
    private ?DateTimeImmutable $opensAt = null;
    private ?DateTimeImmutable $closesAt = null;

    public function __construct(StoreInterface $store, int $day, bool $open)
    {
        $this->day = $day;
        $this->open = $open;
        $this->store = $store;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStore(): StoreInterface
    {
        return $this->store;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function getOpensAt(): ?DateTimeImmutable
    {
        return $this->opensAt;
    }

    public function setOpensAt(?DateTimeImmutable $opensAt): void
    {
        $this->opensAt = $opensAt;
    }

    public function getClosesAt(): ?DateTimeImmutable
    {
        return $this->closesAt;
    }

    public function setClosesAt(?DateTimeImmutable $closesAt): void
    {
        $this->closesAt = $closesAt;
    }

    /** @param StoreOpeningHoursModel $model */
    public function populateFromModel(ModelInterface $model): void
    {
        $this->store = $model->store;
        $this->day = $model->day;
        $this->open = $model->open;
        $this->opensAt = $model->opensAt;
        $this->closesAt = $model->closesAt;
    }
}
