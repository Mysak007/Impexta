<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DateTimeImmutable;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class StoreSpecialOpeningHours implements StoreSpecialOpeningHoursInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private StoreInterface $store;
    private DateTimeImmutable $day;
    private bool $open;
    private ?DateTimeImmutable $opensAt = null;
    private ?DateTimeImmutable $closesAt = null;

    public function __construct(StoreInterface $store, DateTimeImmutable $day, bool $open)
    {
        $this->store = $store;
        $this->day = $day;
        $this->open = $open;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStore(): StoreInterface
    {
        return $this->store;
    }

    public function getDay(): DateTimeImmutable
    {
        return $this->day;
    }

    public function setDay(DateTimeImmutable $day): void
    {
        $this->day = $day;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): void
    {
        $this->open = $open;
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
}
