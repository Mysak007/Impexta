<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

interface StoreInterface extends EntityInterface, HasModelInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getAddress(): StoreAddressInterface;

    public function getContactInformation(): StoreContactInformationInterface;

    /**
     * @return ArrayCollection<int, StoreOpeningHoursInterface>
     */
    public function getOpeningHours(): Collection;

    /**
     * @param ArrayCollection<int, StoreOpeningHoursInterface> $openingHours
     */
    public function setOpeningHours(Collection $openingHours): void;

    public function addOpeningHour(StoreOpeningHoursInterface $openingHours): void;

    public function removeOpeningHour(StoreOpeningHoursInterface $openingHours): void;

    /**
     * @return ArrayCollection<int, StoreSpecialOpeningHoursInterface>
     */
    public function getSpecialOpeningHours(): Collection;

    public function addSpecialOpeningHour(StoreSpecialOpeningHoursInterface $openingHour): void;

    public function removeSpecialOpeningHour(StoreSpecialOpeningHoursInterface $openingHour): void;

    public function populateFromModel(ModelInterface $model): void;
}
