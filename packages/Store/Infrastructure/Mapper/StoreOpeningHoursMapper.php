<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\Mapper;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Factory\StoreOpeningHoursFactory;
use Impexta\Store\Infrastructure\Repository\StoreOpeningHoursRepository;
use Impexta\Store\Presentation\Form\Model\StoreModel;

final class StoreOpeningHoursMapper
{
    private StoreOpeningHoursFactory $openingHoursFactory;
    private StoreOpeningHoursRepository $storeOpeningHoursRepository;

    public function __construct(
        StoreOpeningHoursFactory $openingHoursFactory,
        StoreOpeningHoursRepository $storeOpeningHoursRepository
    ) {
        $this->openingHoursFactory = $openingHoursFactory;
        $this->storeOpeningHoursRepository = $storeOpeningHoursRepository;
    }

    public function mapFromModel(StoreModel $model, Store $store): void
    {
        $store->setName($model->name);
        $store->getAddress()->mapFromModel($model->address->address);
        $store->getContactInformation()->populateFromModel($model->contactInformation);

        $entityHours = clone $store->getOpeningHours();

        foreach ($model->openingHours as $openingHourModel) {
            $openingHour = $store->findOpeningHoursForDay($openingHourModel->day);
            $openingHourModel->store = $store;

            if (!$openingHour) {
                $openingHour = $this->openingHoursFactory->create($openingHourModel);
                $store->addOpeningHour($openingHour);
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
            $store->removeOpeningHour($entityHour);
            $this->storeOpeningHoursRepository->remove($entityHour);
        }
    }
}
