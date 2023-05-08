<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DobryProgramator\SmartformBundle\Entity\AbstractSmartformAddress;
use Impexta\Store\Presentation\Form\Model\StoreAddressModel;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class StoreAddress extends AbstractSmartformAddress implements StoreAddressInterface
{
    use TimestampableEntityTrait;

    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    /** @param StoreAddressModel $model */
    public function populateFromModel(ModelInterface $model): void
    {
        $this->mapFromModel($model->address);
    }
}
