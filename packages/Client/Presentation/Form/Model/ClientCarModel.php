<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientCarModel implements ModelInterface
{
    public int $id;

    /** @Assert\Valid */
    public ?ClientInterface $client = null;

    /** @Assert\Valid */
    public CarInterface $car;

    /** @Assert\Length(max=255,maxMessage="Maximální délka je 255 znaků") */
    public ?string $licensePlate = null;

    /** @Assert\Length(max=17,maxMessage="Maximální délka je 17 znaků") */
    public ?string $vin = null;
    public ?\DateTimeImmutable $technicalInspectionExpiresAt = null;

    /** @Assert\Length(max=255,maxMessage="Maximální délka je 255 znaků") */
    public ?string $ownerName = null;

    /**
     * @param ClientCarInterface $clientCar
     */
    public static function createFromEntity(EntityInterface $clientCar): self
    {
        $model = new self();

        $model->id = $clientCar->getId();
        $model->client = $clientCar->getClient();
        $model->car = $clientCar->getCar();
        $model->licensePlate = $clientCar->getLicensePlate();
        $model->vin = $clientCar->getVin();
        $model->technicalInspectionExpiresAt = $clientCar->getTechnicalInspectionExpiresAt();
        $model->ownerName = $clientCar->getOwnerName();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
