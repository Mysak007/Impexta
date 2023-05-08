<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Factory;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;
use Impexta\Store\Presentation\Form\Model\StoreSpecialOpeningHoursModel;

final class StoreSpecialOpeningHoursFactory
{
    public function create(StoreSpecialOpeningHoursModel $openingHoursModel, Store $store): StoreSpecialOpeningHours
    {
        $openingHours = new StoreSpecialOpeningHours(
            $store,
            $openingHoursModel->day,
            $openingHoursModel->open
        );
        $openingHours->setOpensAt($openingHoursModel->opensAt);
        $openingHours->setClosesAt($openingHoursModel->closesAt);

        return $openingHours;
    }
}
