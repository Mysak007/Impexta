<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Model;

use DobryProgramator\SmartformBundle\Form\Model\SmartformAddressModel;
use Impexta\Store\Domain\Entity\StoreAddressInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreAddressModel implements ModelInterface
{
    /** @Assert\Valid */
    public SmartformAddressModel $address;

    public function __construct()
    {
        $this->address = SmartformAddressModel::createEmpty();
    }

    /**
     * @param StoreAddressInterface $entity
     * @return self
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $model = self::createEmpty();
        $model->address = SmartformAddressModel::createFromEntity($entity);

        return $model;
    }

    /**
     * @return self
     */
    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
