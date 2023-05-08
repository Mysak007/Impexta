<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Factory;

use Impexta\Store\Domain\Entity\StoreOpeningHours;
use Impexta\Store\Presentation\Form\Model\StoreOpeningHoursModel;

final class StoreOpeningHoursFactory
{
    public function create(StoreOpeningHoursModel $openingHoursModel): StoreOpeningHours
    {
        $openingHours = new StoreOpeningHours(
            $openingHoursModel->store,
            $openingHoursModel->day,
            $openingHoursModel->open
        );
        $openingHours->setOpensAt($openingHoursModel->opensAt);
        $openingHours->setClosesAt($openingHoursModel->closesAt);

        return $openingHours;
    }
}
