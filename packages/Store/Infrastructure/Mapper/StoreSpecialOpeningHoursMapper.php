<?php

declare(strict_types=1);

namespace Impexta\Store\Infrastructure\Mapper;

use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;
use Impexta\Store\Presentation\Form\Model\StoreSpecialOpeningHoursModel;

final class StoreSpecialOpeningHoursMapper
{
    public function mapFromModel(
        StoreSpecialOpeningHoursModel $model,
        StoreSpecialOpeningHours $openingHours
    ): void {
        $openingHours->setDay($model->day);
        $openingHours->setOpen($model->open);
        $openingHours->setOpensAt($model->opensAt);
        $openingHours->setClosesAt($model->closesAt);
    }
}
