<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Presentation\Form\Model\StoreModel;

final class StoreFactory
{
    private StoreAddressFactory $addressFactory;
    private StoreContactInformationFactory $contactInformationFactory;
    private StoreOpeningHoursFactory $openingHoursFactory;

    public function __construct(
        StoreAddressFactory $addressFactory,
        StoreContactInformationFactory $contactInformationFactory,
        StoreOpeningHoursFactory $openingHoursFactory
    ) {
        $this->addressFactory = $addressFactory;
        $this->contactInformationFactory = $contactInformationFactory;
        $this->openingHoursFactory = $openingHoursFactory;
    }

    public function create(StoreModel $storeModel): Store
    {
        $storeAddress = $this->addressFactory->create($storeModel->address);
        $contactInformation = $this->contactInformationFactory->create($storeModel->contactInformation);
        $store = new Store($storeModel->name, $storeAddress, $contactInformation);
        $storeOpeningHours = new ArrayCollection();

        foreach ($storeModel->openingHours as $openingHourModel) {
            $openingHourModel->store = $store;
            $openingHour = $this->openingHoursFactory->create($openingHourModel);
            $storeOpeningHours[] = $openingHour;
        }

        $store->setOpeningHours($storeOpeningHours);

        return $store;
    }
}
