<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use DateTimeImmutable;
use Impexta\CarService\Domain\Enum\BusinessCaseCommunicationChannel;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class BusinessCaseCommunication implements BusinessCaseCommunicationInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private BusinessCaseInterface $businessCase;
    private DateTimeImmutable $communicatedAt;
    private BusinessCaseCommunicationChannel $channel;
    private string $communication;

    public function __construct(
        BusinessCaseInterface $businessCase,
        DateTimeImmutable $communicatedAt,
        BusinessCaseCommunicationChannel $channel,
        string $communication
    ) {
        $this->businessCase = $businessCase;
        $this->communicatedAt = $communicatedAt;
        $this->channel = $channel;
        $this->communication = $communication;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBusinessCase(): BusinessCaseInterface
    {
        return $this->businessCase;
    }

    public function getCommunicatedAt(): DateTimeImmutable
    {
        return $this->communicatedAt;
    }

    public function setCommunicatedAt(DateTimeImmutable $communicatedAt): void
    {
        $this->communicatedAt = $communicatedAt;
    }

    public function getChannel(): BusinessCaseCommunicationChannel
    {
        return $this->channel;
    }

    public function setChannel(BusinessCaseCommunicationChannel $channel): void
    {
        $this->channel = $channel;
    }

    public function getCommunication(): string
    {
        return $this->communication;
    }

    public function setCommunication(string $communication): void
    {
        $this->communication = $communication;
    }
}
