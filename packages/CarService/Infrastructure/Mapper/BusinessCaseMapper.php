<?php

declare(strict_types=1);

namespace Impexta\CarService\Infrastructure\Mapper;

use Impexta\CarService\Domain\Entity\BusinessCase;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Impexta\CarService\Domain\Factory\BusinessCaseFileFactory;
use Impexta\CarService\Domain\Factory\BusinessCaseImageFactory;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseFileRepository;
use Impexta\CarService\Infrastructure\Repository\BusinessCaseImageRepository;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseDetailModel;
use Impexta\CarService\Presentation\Form\Model\BusinessCaseModel;

final class BusinessCaseMapper
{
    private BusinessCaseFileRepository $businessCaseFileRepository;
    private BusinessCaseImageRepository $businessCaseImageRepository;
    private BusinessCaseImageFactory $businessCaseImageFactory;
    private BusinessCaseFileFactory $businessCaseFileFactory;
    private BusinessCaseVehicleMapper $businessCaseVehicleMapper;

    public function __construct(
        BusinessCaseFileRepository $businessCaseFileRepository,
        BusinessCaseImageRepository $businessCaseImageRepository,
        BusinessCaseImageFactory $businessCaseImageFactory,
        BusinessCaseFileFactory $businessCaseFileFactory,
        BusinessCaseVehicleMapper $businessCaseVehicleMapper
    ) {
        $this->businessCaseFileRepository = $businessCaseFileRepository;
        $this->businessCaseImageRepository = $businessCaseImageRepository;
        $this->businessCaseImageFactory = $businessCaseImageFactory;
        $this->businessCaseFileFactory = $businessCaseFileFactory;
        $this->businessCaseVehicleMapper = $businessCaseVehicleMapper;
    }

    public function mapFromModel(BusinessCaseInterface $businessCase, BusinessCaseModel $model): void
    {
        $businessCase->setState($model->state);
        $businessCase->setInsuredEvent($model->insuredEvent);
        $businessCase->setPriceEstimate($model->priceEstimate);
        $businessCase->setFinalPrice($model->finalPrice);
        $businessCase->setTakenInAt($model->takenInAt);
        $businessCase->setRealizationAt($model->realizationAt);
        $businessCase->setHandOverAt($model->handOverAt);
        $this->businessCaseVehicleMapper->mapFromModel($businessCase->getVehicle(), $model->vehicle);

        $this->mapEntityImages($businessCase, $model);
        $this->mapEntityFiles($businessCase, $model);
    }

    public function mapFromDetailModel(BusinessCase $businessCase, BusinessCaseDetailModel $model): void
    {
        foreach ($model->files as $modelFile) {
            if ($modelFile->filename !== null) {
                continue;
            }

            $newFile = $this->businessCaseFileFactory->create($modelFile, $businessCase);
            $businessCase->addFile($newFile);
        }

        foreach ($model->images as $modelImage) {
            if ($modelImage->filename !== null) {
                continue;
            }

            $newImage = $this->businessCaseImageFactory->create($modelImage, $businessCase);
            $businessCase->addImage($newImage);
        }
    }

    private function mapEntityImages(BusinessCaseInterface $businessCase, BusinessCaseModel $model): void
    {
        $entityImages = clone $businessCase->getImages();
        $modelImages = $model->images;

        foreach ($modelImages as $modelImage) {
            if ($modelImage->filename === null) {
                $newImage = $this->businessCaseImageFactory->create($modelImage, $businessCase);
                $businessCase->addImage($newImage);

                continue;
            }

            $imageToRemove = $entityImages->filter(static function ($entityImage) use ($modelImage) {
                return $modelImage->filename === $entityImage->getFilename();
            })->first();

            if ($imageToRemove === false) {
                continue;
            }

            $imageToRemove->setFilename($modelImage->filename);
            $imageToRemove->setFile($modelImage->file);

            $entityImages->removeElement($imageToRemove);
        }

        foreach ($entityImages as $entityImage) {
            $businessCase->removeImage($entityImage);
            $this->businessCaseImageRepository->remove($entityImage);
        }
    }

    private function mapEntityFiles(BusinessCaseInterface $businessCase, BusinessCaseModel $model): void
    {
        $entityFiles = clone $businessCase->getFiles();
        $modelFiles = $model->files;

        foreach ($modelFiles as $modelFile) {
            if ($modelFile->filename === null) {
                $newFile = $this->businessCaseFileFactory->create($modelFile, $businessCase);
                $businessCase->addFile($newFile);

                continue;
            }

            $fileToRemove = $entityFiles->filter(static function ($entityFile) use ($modelFile) {
                return $modelFile->filename === $entityFile->getFilename();
            })->first();

            if ($fileToRemove === false) {
                continue;
            }

            $fileToRemove->setFilename($modelFile->filename);
            $fileToRemove->setFile($modelFile->file);

            $entityFiles->removeElement($fileToRemove);
        }

        foreach ($entityFiles as $entityFile) {
            $businessCase->removeFile($entityFile);
            $this->businessCaseFileRepository->remove($entityFile);
        }
    }
}
