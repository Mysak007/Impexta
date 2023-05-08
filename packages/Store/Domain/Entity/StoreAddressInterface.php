<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Entity;

use DobryProgramator\SmartformBundle\Entity\SmartformAddressInterface;
use DobryProgramator\SmartformBundle\Form\Model\SmartformAddressModel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\HasModelInterface;

interface StoreAddressInterface extends EntityInterface, HasModelInterface, SmartformAddressInterface
{
    public function mapFromModel(SmartformAddressModel $model): void;
}
