<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Factory;

use Impexta\Store\Domain\Entity\StoreContactInformation;
use Impexta\Store\Presentation\Form\Model\StoreContactInformationModel;

final class StoreContactInformationFactory
{
    public function create(StoreContactInformationModel $contactInformationModel): StoreContactInformation
    {
        $contactInformation = new StoreContactInformation();
        $contactInformation->setEmail($contactInformationModel->email);
        $contactInformation->setPhone($contactInformationModel->phone);
        $contactInformation->setLandline($contactInformationModel->landline);
        $contactInformation->setSkype($contactInformationModel->skype);

        return $contactInformation;
    }
}
