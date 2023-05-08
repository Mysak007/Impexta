<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use DobryProgramator\SmartformBundle\Form\Model\SmartformAddressModel;
use Impexta\Client\Domain\Entity\ClientAddressInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientAddressModel implements ModelInterface
{
    /**
     * @Assert\Length(max=255)
     * @Assert\Expression("!this.address == null && !this.name == null", message="Adresa musí být vyplněna")
     */
    public string $name;

    /** @Assert\Valid */
    public SmartformAddressModel $address;

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }

    /**
     * @param ClientAddressInterface $clientAddress
     */
    public static function createFromEntity(EntityInterface $clientAddress): self
    {
        $model = new self();

        $model->name = $clientAddress->getName();

        $model->address = SmartformAddressModel::createFromEntity($clientAddress);

        return $model;
    }
}
