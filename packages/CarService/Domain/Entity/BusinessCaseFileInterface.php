<?php

declare(strict_types=1);

namespace Impexta\CarService\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Symfony\Component\HttpFoundation\File\File;

interface BusinessCaseFileInterface extends EntityInterface
{
    public function getId(): int;

    public function getBusinessCase(): BusinessCaseInterface;

    public function getFilename(): ?string;

    public function setFilename(?string $filename): void;

    public function getFile(): ?File;

    public function setFile(?File $file): void;
}
