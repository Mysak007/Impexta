<?php

declare(strict_types=1);

namespace Impexta\Client\Api\Factory;

use Impexta\Client\Api\Model\ClientCarModel;
use Impexta\Client\Api\Model\ClientCarsModel;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;

final class ClientCarsModelFactory
{
    public static function create(ClientInterface $client): ClientCarsModel
    {
        $clientCarsModel = new ClientCarsModel();

        /** @var ClientCarInterface $clientCar */
        foreach ($client->getClientCars() as $clientCar) {
            $clientCarsModel->addCar(
                new ClientCarModel(
                    $clientCar->getId(),
                    $clientCar->getCar()->getManufacturer()->getName(),
                    $clientCar->getCar()->getModel(),
                    $clientCar->getCar()->getYearOfManufacture(),
                    $clientCar->getLicensePlate()
                )
            );
        }

        return $clientCarsModel;
    }
}
