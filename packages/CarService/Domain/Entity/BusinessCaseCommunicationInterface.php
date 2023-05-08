<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use DateTimeImmutable;
use Impexta\CarService\Domain\Enum\BusinessCaseCommunicationChannel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface BusinessCaseCommunicationInterface extends EntityInterface
{
    public function getId(): int;

    public function getBusinessCase(): BusinessCaseInterface;

    public function getCommunicatedAt(): DateTimeImmutable;

    public function setCommunicatedAt(DateTimeImmutable $communicatedAt): void;

    public function getChannel(): BusinessCaseCommunicationChannel;

    public function setChannel(BusinessCaseCommunicationChannel $channel): void;

    public function getCommunication(): string;

    public function setCommunication(string $communication): void;
}
