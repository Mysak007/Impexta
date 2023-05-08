<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\Mapper;

use Impexta\Client\Domain\Entity\ClientContactDetailsInterface;
use Impexta\Client\Presentation\Form\Model\ClientContactDetailsModel;

final class ClientContactDetailsMapper
{
    public function mapFromModel(
        ClientContactDetailsModel $model,
        ClientContactDetailsInterface $clientContactDetails
    ): void {
        $clientContactDetails->setEmail($model->email);
        $clientContactDetails->setPhone($model->phone);
    }
}
