<?php

declare(strict_types=1);

namespace Impexta\Order\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface OnlinePaymentInterface extends EntityInterface
{
    public function getExternalId(): string;

    public function setExternalId(string $externalId): void;
}
