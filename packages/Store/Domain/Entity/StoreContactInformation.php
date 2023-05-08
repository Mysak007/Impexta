<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use Impexta\Store\Presentation\Form\Model\StoreContactInformationModel;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class StoreContactInformation implements StoreContactInformationInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $landline = null;
    private ?string $skype = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getLandline(): ?string
    {
        return $this->landline;
    }

    public function setLandline(?string $landline): void
    {
        $this->landline = $landline;
    }

    public function getSkype(): ?string
    {
        return $this->skype;
    }

    public function setSkype(?string $skype): void
    {
        $this->skype = $skype;
    }

    /** @param StoreContactInformationModel $model */
    public function populateFromModel(ModelInterface $model): void
    {
        $this->email = $model->email;
        $this->phone = $model->phone;
        $this->landline = $model->landline;
        $this->skype = $model->skype;
    }
}
