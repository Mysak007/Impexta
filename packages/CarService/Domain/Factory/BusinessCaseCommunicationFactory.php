<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Factory;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunication;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseCommunicationModel;

final class BusinessCaseCommunicationFactory
{
    public function create(
        BusinessCase $businessCase,
        BusinessCaseCommunicationModel $model
    ): BusinessCaseCommunication {
        return new BusinessCaseCommunication(
            $businessCase,
            $model->communicatedAt,
            $model->channel,
            $model->communication
        );
    }
}
