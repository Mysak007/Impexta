<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Factory;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseModel;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Infrastructure\Repository\ClientRepository;

final class BusinessCaseFactory
{
    private ClientRepository $clientRepository;
    private BusinessCaseVehicleFactory $businessCaseVehicleFactory;
    private BusinessCaseImageFactory $businessCaseImageFactory;
    private BusinessCaseFileFactory $businessCaseFileFactory;

    public function __construct(
        ClientRepository $clientRepository,
        BusinessCaseVehicleFactory $businessCaseVehicleFactory,
        BusinessCaseImageFactory $businessCaseImageFactory,
        BusinessCaseFileFactory $businessCaseFileFactory
    ) {
        $this->clientRepository = $clientRepository;
        $this->businessCaseVehicleFactory = $businessCaseVehicleFactory;
        $this->businessCaseImageFactory = $businessCaseImageFactory;
        $this->businessCaseFileFactory = $businessCaseFileFactory;
    }

    public function create(BusinessCaseModel $model): BusinessCase
    {
        /** @var ClientInterface $client */
        $client = $this->clientRepository->findOneBy(['id' => $model->client]);
        $vehicle = $this->businessCaseVehicleFactory->create($model->vehicle);

        $businessCase = new BusinessCase(
            $client,
            $vehicle,
            $model->state,
            $model->insuredEvent,
            $model->takenInAt,
            $model->realizationAt,
            $model->handOverAt
        );

        $businessCase->setPriceEstimate($model->priceEstimate);
        $businessCase->setFinalPrice($model->finalPrice);

        foreach ($model->images as $imageModel) {
            $image = $this->businessCaseImageFactory->create($imageModel, $businessCase);
            $businessCase->addImage($image);
        }

        foreach ($model->files as $fileModel) {
            $file = $this->businessCaseFileFactory->create($fileModel, $businessCase);
            $businessCase->addFile($file);
        }

        return $businessCase;
    }
}
