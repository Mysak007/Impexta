<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Entity;

use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Symfony\Component\HttpFoundation\File\File;

interface SecondHandProductImageInterface extends EntityInterface
{
    public function getSecondHandProduct(): SecondHandProductInterface;

    public function isMain(): bool;

    public function setIsMain(bool $isMain): void;

    public function getFilename(): ?string;

    public function setFilename(?string $filename): void;

    public function getFile(): ?File;

    public function setFile(?File $file): void;
}
