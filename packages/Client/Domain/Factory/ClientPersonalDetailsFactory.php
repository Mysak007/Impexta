<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientPersonalDetails;
use Impexta\Client\Domain\Entity\ClientPersonalDetailsInterface;
use Impexta\Client\Presentation\Form\Model\ClientPersonalDetailsModel;

final class ClientPersonalDetailsFactory
{
    public static function createFromModel(ClientPersonalDetailsModel $model): ClientPersonalDetailsInterface
    {
        $personalDetails = new ClientPersonalDetails();

        $personalDetails->setFirstName($model->firstName);
        $personalDetails->setLastName($model->lastName);
        $personalDetails->setCompanyName($model->companyName);
        $personalDetails->setVatId($model->vatId);
        $personalDetails->setTaxId($model->taxId);

        return $personalDetails;
    }
}
