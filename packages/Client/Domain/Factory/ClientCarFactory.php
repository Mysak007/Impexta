<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientCar;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Presentation\Form\Model\ClientCarModel;

final class ClientCarFactory
{
    public static function create(ClientCarModel $model, ClientInterface $client): ClientCarInterface
    {
        $clientCar = new ClientCar(
            $model->car,
            $client
        );

        $clientCar->setLicensePlate($model->licensePlate);
        $clientCar->setVin($model->vin);
        $clientCar->setTechnicalInspectionExpiresAt($model->technicalInspectionExpiresAt);
        $clientCar->setOwnerName($model->ownerName);

        return $clientCar;
    }
}
