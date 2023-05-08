<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use DobryProgramator\SmartformBundle\Entity\SmartformAddressInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientAddressInterface extends EntityInterface, SmartformAddressInterface
{
    public function getName(): string;

    public function setName(string $name): void;
}
