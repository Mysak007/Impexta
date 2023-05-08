<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Impexta\CarService\Domain\Enum\BusinessCaseState;
use Impexta\Client\Domain\Entity\ClientInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Money;

interface BusinessCaseInterface extends EntityInterface
{
    public function getId(): int;

    public function getClient(): ClientInterface;

    public function getVehicle(): BusinessCaseVehicleInterface;

    public function getState(): BusinessCaseState;

    public function setState(BusinessCaseState $state): void;

    public function isInsuredEvent(): bool;

    public function setInsuredEvent(bool $insuredEvent): void;

    public function getPriceEstimate(): Money;

    public function setPriceEstimate(Money $priceEstimate): void;

    public function getFinalPrice(): Money;

    public function setFinalPrice(Money $finalPrice): void;

    public function getTakenInAt(): DateTimeImmutable;

    public function setTakenInAt(DateTimeImmutable $takenInAt): void;

    public function getRealizationAt(): DateTimeImmutable;

    public function setRealizationAt(DateTimeImmutable $realizationAt): void;

    public function getHandOverAt(): DateTimeImmutable;

    public function setHandOverAt(DateTimeImmutable $handOverAt): void;

    /** @return Collection<int, BusinessCaseImageInterface> */
    public function getImages(): Collection;

    public function addImage(BusinessCaseImageInterface $image): void;

    public function removeImage(BusinessCaseImageInterface $image): void;

    /** @return Collection<int, BusinessCaseFileInterface> */
    public function getFiles(): Collection;

    public function addFile(BusinessCaseFileInterface $file): void;

    public function removeFile(BusinessCaseFileInterface $file): void;
}
