<?php

declare(strict_types=1);

namespace Impexta\CarService\Presentation\Form\Model;

use DateTimeImmutable;
use Impexta\CarService\Domain\Entity\BusinessCaseCommunicationInterface;
use Impexta\CarService\Domain\Enum\BusinessCaseCommunicationChannel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

final class BusinessCaseCommunicationModel implements ModelInterface
{
    public DateTimeImmutable $communicatedAt;
    public BusinessCaseCommunicationChannel $channel;
    public string $communication;

    /**
     * @param BusinessCaseCommunicationInterface $businessCase
     */
    public static function createFromEntity(EntityInterface $businessCase): self
    {
        $businessCaseModel = self::createEmpty();
        $businessCaseModel->communicatedAt = $businessCase->getCommunicatedAt();
        $businessCaseModel->channel = $businessCase->getChannel();
        $businessCaseModel->communication = $businessCase->getCommunication();

        return $businessCaseModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
