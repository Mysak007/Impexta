<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use App\Eshop\Enum\Country;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\Client\Domain\Enum\ClientGroup;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientModel implements ModelInterface
{
    /** @Assert\Valid */
    public ClientPersonalDetailsModel $personalDetails;

    /** @Assert\Valid */
    public ClientContactDetailsModel $contactDetails;

    /** @Assert\Valid */
    public ?ClientBankAccountModel $bankAccount = null;

    /**
     * @Assert\Valid
     * @Assert\NotBlank
     */
    public ClientBillingAddressModel $billingAddress;

    /** @Assert\Valid */
    public ?ClientShippingAddressModel $shippingAddress = null;
    public ClientGroup $clientGroup;
    public string $currency;
    public Country $country;

    /**
     * @Assert\Image(maxSize="1024k")
     * @Assert\Valid
     */
    public ?string $logo = null;

    /** @Assert\NotBlank */
    public int $sale;
    public ?string $note = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, ClientCarModel> $clientCars
     */
    public Collection $clientCars;

    public function __construct()
    {
        $this->clientCars = new ArrayCollection();
    }

    /**
     * @param ClientInterface $client
     */
    public static function createFromEntity(EntityInterface $client): self
    {
        $model = new self();

        $model->personalDetails = ClientPersonalDetailsModel::createFromEntity($client->getPersonalDetails());
        $model->contactDetails = ClientContactDetailsModel::createFromEntity($client->getContactDetails());
        $model->billingAddress = ClientBillingAddressModel::createFromEntity($client->getBillingAddress());
        $model->clientGroup = $client->getClientGroup();
        $model->currency = $client->getCurrency()->getCode();
        $model->country = $client->getCountry();
        $model->sale = $client->getSale();
        $model->note = $client->getNote();

        $defaultShippingAddress = $client->getDefaultShippingAddress();

        if ($defaultShippingAddress) {
            $model->shippingAddress = ClientShippingAddressModel::createFromEntity($defaultShippingAddress);
        }

        $clientBankAccount = $client->getBankAccount();

        if ($clientBankAccount) {
            $model->bankAccount = ClientBankAccountModel::createFromEntity($clientBankAccount);
        }

        foreach ($client->getClientCars() as $car) {
            $model->clientCars[] = ClientCarModel::createFromEntity($car);
        }

        foreach ($client->getClientCars() as $car) {
            $model->clientCars[] = ClientCarModel::createFromEntity($car);
        }

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
