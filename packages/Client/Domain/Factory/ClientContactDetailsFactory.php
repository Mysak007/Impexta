<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use Impexta\Client\Domain\Entity\ClientContactDetails;
use Impexta\Client\Domain\Entity\ClientContactDetailsInterface;
use Impexta\Client\Presentation\Form\Model\ClientContactDetailsModel;

final class ClientContactDetailsFactory
{
    public static function create(ClientContactDetailsModel $model): ClientContactDetailsInterface
    {
        return new ClientContactDetails(
            $model->email,
            $model->phone
        );
    }
}
