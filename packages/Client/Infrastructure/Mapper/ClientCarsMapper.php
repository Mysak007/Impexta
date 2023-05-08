<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Factory\ClientCarFactory;
use Impexta\Client\Infrastructure\Repository\ClientCarRepository;
use Impexta\Client\Presentation\Form\Model\ClientModel;

final class ClientCarsMapper
{
    private ClientCarRepository $clientCarRepository;

    public function __construct(ClientCarRepository $clientCarRepository)
    {
        $this->clientCarRepository = $clientCarRepository;
    }

    public function mapFromModel(ClientInterface $client, ClientModel $model): void
    {
        $entityCars = clone $client->getClientCars();
        $modelCars = $model->clientCars;

        foreach ($modelCars as $modelCar) {
            if ($modelCar->client === null) {
                $newCar = ClientCarFactory::create($modelCar, $client);
                $client->addCar($newCar);

                continue;
            }

            $carToRemove = $entityCars->filter(static function ($entityCar) use ($modelCar) {
                return $modelCar->id === $entityCar->getId();
            })->first();

            if ($carToRemove === false) {
                continue;
            }

            $carToRemove->setCar($modelCar->car);
            $carToRemove->setLicensePlate($modelCar->licensePlate);
            $carToRemove->setVin($modelCar->vin);
            $carToRemove->setTechnicalInspectionExpiresAt($modelCar->technicalInspectionExpiresAt);
            $carToRemove->setOwnerName($modelCar->ownerName);

            $entityCars->removeElement($carToRemove);
        }

        foreach ($entityCars as $entityCar) {
            $client->removeCar($entityCar);
            $this->clientCarRepository->remove($entityCar);
        }
    }
}
