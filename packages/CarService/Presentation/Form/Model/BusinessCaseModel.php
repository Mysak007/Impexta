<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\CarService\Domain\Entity\BusinessCaseInterface;
use Impexta\CarService\Domain\Enum\BusinessCaseState;
use Impexta\Client\Domain\Entity\ClientInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class BusinessCaseModel implements ModelInterface
{
    /** @var ClientInterface|string */
    public $client;

    /** @Assert\Valid */
    public BusinessCaseVehicleModel $vehicle;

    /** @Assert\Valid */
    public BusinessCaseState $state;
    public bool $insuredEvent;
    public Money $priceEstimate;
    public Money $finalPrice;
    public DateTimeImmutable $takenInAt;

    /**
     * @Assert\Expression("this.realizationAt > this.takenInAt",
     *      message="Datum realizace musí být vyšší než datum převzetí")
     */
    public DateTimeImmutable $realizationAt;

    /**
     * @Assert\Expression("this.handOverAt > this.realizationAt",
     *      message="Datum předání musí být vyšší než datum realizace")
     */
    public DateTimeImmutable $handOverAt;

    /** @var ArrayCollection<int, BusinessCaseImageModel> $images */
    public Collection $images;

    /** @var ArrayCollection<int, BusinessCaseFileModel> $files */
    public Collection $files;

    public function __construct()
    {
        $this->vehicle = BusinessCaseVehicleModel::createEmpty();
        $this->images = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    /**
     * @param BusinessCaseInterface $businessCase
     */
    public static function createFromEntity(EntityInterface $businessCase): self
    {
        $businessCaseModel = self::createEmpty();
        $businessCaseModel->client = $businessCase->getClient();
        $businessCaseModel->state = $businessCase->getState();
        $businessCaseModel->insuredEvent = $businessCase->isInsuredEvent();
        $businessCaseModel->priceEstimate = $businessCase->getPriceEstimate();
        $businessCaseModel->finalPrice = $businessCase->getFinalPrice();
        $businessCaseModel->takenInAt = $businessCase->getTakenInAt();
        $businessCaseModel->realizationAt = $businessCase->getRealizationAt();
        $businessCaseModel->handOverAt = $businessCase->getHandOverAt();
        $businessCaseModel->vehicle = BusinessCaseVehicleModel::createFromEntity($businessCase->getVehicle());

        $images = [];

        foreach ($businessCase->getImages() as $image) {
            $images[] = BusinessCaseImageModel::createFromEntity($image);
        }

        $businessCaseModel->images = new ArrayCollection($images);

        $files = [];

        foreach ($businessCase->getFiles() as $file) {
            $files[] = BusinessCaseFileModel::createFromEntity($file);
        }

        $businessCaseModel->files = new ArrayCollection($files);

        return $businessCaseModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
