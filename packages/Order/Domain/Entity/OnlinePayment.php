<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class OnlinePayment implements OnlinePaymentInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $externalId;

    public function __construct(
        string $externalId
    ) {

        $this->externalId = $externalId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }
}
