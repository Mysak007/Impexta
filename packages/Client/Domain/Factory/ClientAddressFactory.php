<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Factory;

use DobryProgramator\SmartformBundle\Form\DataMapper\SmartformAddressMapper;
use Impexta\Client\Domain\Entity\ClientAddress;
use Impexta\Client\Domain\Entity\ClientAddressInterface;
use Impexta\Client\Presentation\Form\Model\ClientAddressModel;

final class ClientAddressFactory
{
    private SmartformAddressMapper $smartformAddressMapper;

    public function __construct(SmartformAddressMapper $smartformAddressMapper)
    {
        $this->smartformAddressMapper = $smartformAddressMapper;
    }

    public function create(ClientAddressModel $model): ClientAddressInterface
    {
        $clientAddress = new ClientAddress($model->name);
        $this->smartformAddressMapper->mapEntityFromModel($clientAddress, $model->address);

        return $clientAddress;
    }
}
