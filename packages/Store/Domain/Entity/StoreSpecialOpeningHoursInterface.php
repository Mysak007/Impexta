<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DateTimeImmutable;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface StoreSpecialOpeningHoursInterface extends EntityInterface
{
    public function getStore(): StoreInterface;

    public function getDay(): DateTimeImmutable;

    public function setDay(DateTimeImmutable $day): void;

    public function isOpen(): bool;

    public function setOpen(bool $open): void;

    public function getOpensAt(): ?DateTimeImmutable;

    public function setOpensAt(?DateTimeImmutable $opensAt): void;

    public function getClosesAt(): ?DateTimeImmutable;

    public function setClosesAt(?DateTimeImmutable $closesAt): void;
}
