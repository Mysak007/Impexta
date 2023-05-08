<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientPersonalDetailsInterface;
use Impexta\Client\Presentation\Form\Model\ClientPersonalDetailsModel;

final class ClientPersonalDetailsMapper
{
    public function mapFromModel(
        ClientPersonalDetailsModel $model,
        ClientPersonalDetailsInterface $clientPersonalDetails
    ): void {
        $clientPersonalDetails->setTaxId($model->taxId);
        $clientPersonalDetails->setVatId($model->vatId);
        $clientPersonalDetails->setVatIdSk($model->vatIdSk);
        $clientPersonalDetails->setFirstName($model->firstName);
        $clientPersonalDetails->setLastName($model->lastName);
        $clientPersonalDetails->setCompanyName($model->companyName);
    }
}
