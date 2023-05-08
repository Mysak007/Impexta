<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Mapper;

use Impexta\CarService\Domain\Entity\BusinessCaseCommunicationInterface;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseCommunicationModel;

final class BusinessCaseCommunicationMapper
{
    public function mapFromModel(
        BusinessCaseCommunicationInterface $businessCaseCommunication,
        BusinessCaseCommunicationModel $model
    ): void {
        $businessCaseCommunication->setCommunicatedAt($model->communicatedAt);
        $businessCaseCommunication->setChannel($model->channel);
        $businessCaseCommunication->setCommunication($model->communication);
    }
}
