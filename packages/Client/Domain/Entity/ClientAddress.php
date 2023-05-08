<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use DobryProgramator\SmartformBundle\Entity\AbstractSmartformAddress;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class ClientAddress extends AbstractSmartformAddress implements ClientAddressInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
