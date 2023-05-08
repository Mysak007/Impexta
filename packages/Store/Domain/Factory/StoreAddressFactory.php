<?php

declare(strict_types=1);

namespace Impexta\Store\Domain\Factory;

use DobryProgramator\SmartformBundle\Form\DataMapper\SmartformAddressMapper;
use Impexta\Store\Domain\Entity\StoreAddress;
use Impexta\Store\Presentation\Form\Model\StoreAddressModel;

final class StoreAddressFactory
{
    private SmartformAddressMapper $smartformAddressMapper;

    public function __construct(SmartformAddressMapper $smartformAddressMapper)
    {
        $this->smartformAddressMapper = $smartformAddressMapper;
    }

    public function create(StoreAddressModel $addressModel): StoreAddress
    {
        $address = new StoreAddress();

        $this->smartformAddressMapper->mapEntityFromModel($address, $addressModel->address);

        return $address;
    }
}
