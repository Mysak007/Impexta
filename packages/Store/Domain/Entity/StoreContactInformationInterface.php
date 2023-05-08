<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use Impexta\Store\Presentation\Form\Model\StoreContactInformationModel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;

interface StoreContactInformationInterface extends EntityInterface, HasModelInterface
{
    public function getEmail(): ?string;

    public function setEmail(?string $email): void;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): void;

    public function getLandline(): ?string;

    public function setLandline(?string $landline): void;

    public function getSkype(): ?string;

    public function setSkype(?string $skype): void;

    /** @param StoreContactInformationModel $model */
    public function populateFromModel(ModelInterface $model): void;
}
