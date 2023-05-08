<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Store\Presentation\Form\Model\StoreModel;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class Store implements StoreInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;
    private StoreAddressInterface $address;
    private StoreContactInformationInterface $contactInformation;

    /** @var ArrayCollection<int,StoreOpeningHoursInterface> $openingHours */
    private Collection $openingHours;

    /** @var ArrayCollection<int,StoreSpecialOpeningHoursInterface> $specialOpeningHours */
    private Collection $specialOpeningHours;

    public function __construct(
        string $name,
        StoreAddressInterface $address,
        StoreContactInformationInterface $contactInformation
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->contactInformation = $contactInformation;
        $this->openingHours = new ArrayCollection();
        $this->specialOpeningHours = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): StoreAddressInterface
    {
        return $this->address;
    }

    public function getContactInformation(): StoreContactInformationInterface
    {
        return $this->contactInformation;
    }

    /**
     * @return ArrayCollection<int, StoreOpeningHoursInterface>
     */
    public function getOpeningHours(): Collection
    {
        return $this->openingHours;
    }

    /**
     * @param ArrayCollection<mixed,mixed> $openingHours
     */
    public function setOpeningHours(Collection $openingHours): void
    {
        $this->openingHours = $openingHours;
    }

    public function addOpeningHour(StoreOpeningHoursInterface $openingHours): void
    {
        $this->openingHours[] = $openingHours;
    }

    public function removeOpeningHour(StoreOpeningHoursInterface $openingHours): void
    {
        $this->openingHours->removeElement($openingHours);
    }

    /**
     * @return ArrayCollection<int, StoreSpecialOpeningHoursInterface>
     */
    public function getSpecialOpeningHours(): Collection
    {
        return $this->specialOpeningHours;
    }

    public function addSpecialOpeningHour(StoreSpecialOpeningHoursInterface $openingHour): void
    {
        $this->getSpecialOpeningHours()->add($openingHour);
    }

    public function removeSpecialOpeningHour(StoreSpecialOpeningHoursInterface $openingHour): void
    {
        $this->specialOpeningHours->removeElement($openingHour);
    }

    /**
     * @param StoreModel $model
     */
    public function populateFromModel(
        ModelInterface $model
    ): void {
        $this->setName($model->name);
        $this->address->mapFromModel($model->address->address);
        $this->contactInformation->populateFromModel($model->contactInformation);

        $entityHours = clone $this->getOpeningHours();

        foreach ($model->openingHours as $openingHourModel) {
            $openingHour = $this->findOpeningHoursForDay($openingHourModel->day);
            $openingHourModel->store = $this;

            if (!$openingHour) {
                $openingHour = new StoreOpeningHours($this, $openingHourModel->day, $openingHourModel->open);
                $this->addOpeningHour($openingHour);
            }

            $openingHour->populateFromModel($openingHourModel);

            $openingHourToRemove = $entityHours->filter(static function ($entityHour) use ($openingHourModel) {
                return $openingHourModel->day === $entityHour->getDay();
            })->first();

            if ($openingHourToRemove === false) {
                continue;
            }

            $entityHours->removeElement($openingHourToRemove);
        }

        foreach ($entityHours as $entityHour) {
            $this->removeOpeningHour($entityHour);
        }
    }

    public function findOpeningHoursForDay(int $day): ?StoreOpeningHoursInterface
    {
        $result = $this->openingHours->filter(
            static function ($openingHour) use ($day) {
                return $openingHour->getDay() === $day;
            }
        )->first();

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function findSpecialOpeningHoursForCurrentDay(): ?StoreSpecialOpeningHoursInterface
    {
        $today = new DateTime();

        $storeSpecialOpeningHour = $this->specialOpeningHours->filter(
            static function ($specialOpeningHour) use ($today) {
                return date_diff(DateTime::createFromImmutable($specialOpeningHour->getDay()), $today)->d === 0;
            }
        )->first();

        if (!$storeSpecialOpeningHour) {
            return null;
        }

        return $storeSpecialOpeningHour;
    }
}
