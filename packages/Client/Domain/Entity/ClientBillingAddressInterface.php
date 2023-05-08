<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use Impexta\Client\Presentation\Form\Model\ClientBillingAddressModel;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface ClientBillingAddressInterface extends EntityInterface
{
    public function getAddress(): ClientAddressInterface;

    public function setAddress(ClientAddressInterface $address): void;

    public function mapFromModel(ClientBillingAddressModel $model): void;
}
