<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DateTimeImmutable;
use Impexta\Store\Presentation\Form\Model\StoreOpeningHoursModel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

interface StoreOpeningHoursInterface extends EntityInterface, HasModelInterface
{
    public function getStore(): StoreInterface;

    public function getDay(): int;

    public function isOpen(): bool;

    public function getOpensAt(): ?DateTimeImmutable;

    public function setOpensAt(?DateTimeImmutable $opensAt): void;

    public function getClosesAt(): ?DateTimeImmutable;

    public function setClosesAt(?DateTimeImmutable $closesAt): void;

    /** @param StoreOpeningHoursModel $model */
    public function populateFromModel(ModelInterface $model): void;
}
