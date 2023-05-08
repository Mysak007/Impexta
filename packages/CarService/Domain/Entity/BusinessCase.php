<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\CarService\Domain\Enum\BusinessCaseState;
use Impexta\Client\Domain\Entity\ClientInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Money;

class BusinessCase implements BusinessCaseInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientInterface $client;
    private BusinessCaseVehicleInterface $vehicle;
    private BusinessCaseState $state;
    private bool $insuredEvent;
    private Money $priceEstimate;
    private Money $finalPrice;
    private DateTimeImmutable $takenInAt;
    private DateTimeImmutable $realizationAt;
    private DateTimeImmutable $handOverAt;

    /** @var ArrayCollection<int,BusinessCaseImageInterface> $images */
    private Collection $images;

    /** @var ArrayCollection<int,BusinessCaseFileInterface> $files */
    private Collection $files;

    public function __construct(
        ClientInterface $client,
        BusinessCaseVehicleInterface $vehicle,
        BusinessCaseState $state,
        bool $insuredEvent,
        DateTimeImmutable $takenInAt,
        DateTimeImmutable $realizationAt,
        DateTimeImmutable $handOverAt
    ) {
        $this->client = $client;
        $this->vehicle = $vehicle;
        $this->state = $state;
        $this->insuredEvent = $insuredEvent;
        $this->takenInAt = $takenInAt;
        $this->realizationAt = $realizationAt;
        $this->handOverAt = $handOverAt;
        $this->nullPrices($client);
        $this->images = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getVehicle(): BusinessCaseVehicleInterface
    {
        return $this->vehicle;
    }

    public function getState(): BusinessCaseState
    {
        return $this->state;
    }

    public function setState(BusinessCaseState $state): void
    {
        $this->state = $state;
    }

    public function isInsuredEvent(): bool
    {
        return $this->insuredEvent;
    }

    public function setInsuredEvent(bool $insuredEvent): void
    {
        $this->insuredEvent = $insuredEvent;
    }

    public function getPriceEstimate(): Money
    {
        return $this->priceEstimate;
    }

    public function setPriceEstimate(Money $priceEstimate): void
    {
        $this->priceEstimate = $priceEstimate;
    }

    public function getFinalPrice(): Money
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(Money $finalPrice): void
    {
        $this->finalPrice = $finalPrice;
    }

    public function getTakenInAt(): DateTimeImmutable
    {
        return $this->takenInAt;
    }

    public function setTakenInAt(DateTimeImmutable $takenInAt): void
    {
        $this->takenInAt = $takenInAt;
    }

    public function getRealizationAt(): DateTimeImmutable
    {
        return $this->realizationAt;
    }

    public function setRealizationAt(DateTimeImmutable $realizationAt): void
    {
        $this->realizationAt = $realizationAt;
    }

    public function getHandOverAt(): DateTimeImmutable
    {
        return $this->handOverAt;
    }

    public function setHandOverAt(DateTimeImmutable $handOverAt): void
    {
        $this->handOverAt = $handOverAt;
    }

    /** @return Collection<int, BusinessCaseImageInterface> */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(BusinessCaseImageInterface $image): void
    {
        $images = $this->getImages();
        $images->add($image);
    }

    public function removeImage(BusinessCaseImageInterface $image): void
    {
        $this->getImages()->removeElement($image);
    }

    /** @return Collection<int, BusinessCaseFileInterface> */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(BusinessCaseFileInterface $file): void
    {
        $files = $this->getFiles();
        $files->add($file);
    }

    public function removeFile(BusinessCaseFileInterface $file): void
    {
        $this->getFiles()->removeElement($file);
    }

    private function nullPrices(ClientInterface $client): void
    {
        $this->finalPrice = new Money(0, $client->getCurrency());
        $this->priceEstimate = new Money(0, $client->getCurrency());
    }
}
