<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use App\Eshop\Enum\Country;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;
use Money\Currency;

class Client implements ClientInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private ClientPersonalDetailsInterface $personalDetails;
    private ClientContactDetailsInterface $contactDetails;
    private ?ClientBankAccountInterface $bankAccount = null;
    private ClientBillingAddressInterface $billingAddress;

    /** @var ArrayCollection<int, ClientShippingAddressInterface> $shippingAddresses */
    private Collection $shippingAddresses;
    private ClientGroup $clientGroup;
    private Currency $currency;
    private Country $country;
    private ?string $logo = null;
    private int $sale;
    private ?string $note = null;
    private ?ShopUserInterface $shopUser;

    /** @var ArrayCollection<int,ClientCarInterface> $clientCars */
    private Collection $clientCars;

    public function __construct(
        ClientPersonalDetailsInterface $personalDetails,
        ClientContactDetailsInterface $contactDetails,
        ClientBillingAddressInterface $billingAddress,
        ClientGroup $clientGroup,
        Currency $currency,
        Country $country,
        int $sale
    ) {
        $this->personalDetails = $personalDetails;
        $this->contactDetails = $contactDetails;
        $this->billingAddress = $billingAddress;
        $this->shippingAddresses = new ArrayCollection();
        $this->clientGroup = $clientGroup;
        $this->currency = $currency;
        $this->sale = $sale;
        $this->country = $country;
        $this->clientCars = new ArrayCollection();
        $this->country = $country;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPersonalDetails(): ClientPersonalDetailsInterface
    {
        return $this->personalDetails;
    }

    public function getContactDetails(): ClientContactDetailsInterface
    {
        return $this->contactDetails;
    }

    public function getBankAccount(): ?ClientBankAccountInterface
    {
        return $this->bankAccount;
    }

    public function getBillingAddress(): ClientBillingAddressInterface
    {
        return $this->billingAddress;
    }

    public function getClientGroup(): ClientGroup
    {
        return $this->clientGroup;
    }

    public function setClientGroup(ClientGroup $clientGroup): void
    {
        $this->clientGroup = $clientGroup;
    }

    public function setBankAccount(?ClientBankAccountInterface $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    public function getSale(): int
    {
        return $this->sale;
    }

    public function setSale(int $sale): void
    {
        $this->sale = $sale;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /** @return Collection<int, ClientCarInterface> */
    public function getClientCars(): Collection
    {
        return $this->clientCars;
    }

    public function addCar(ClientCarInterface $car): void
    {
        $cars = $this->getClientCars();
        $cars->add($car);
    }

    public function removeCar(ClientCarInterface $car): void
    {
        $this->clientCars->removeElement($car);
    }

    /** @param ArrayCollection<int, ClientCarInterface> $cars */
    public function setCars(Collection $cars): void
    {
        $this->clientCars = $cars;
    }

    /** @return ArrayCollection<int, ClientShippingAddressInterface> */
    public function getShippingAddresses(): Collection
    {
        return $this->shippingAddresses;
    }

    public function addShippingAddress(ClientShippingAddressInterface $clientAddress): void
    {
        $shippingAddresses = $this->getShippingAddresses();
        $shippingAddresses->add($clientAddress);
    }

    public function removeShippingAddress(ClientShippingAddressInterface $clientAddress): void
    {
        $this->shippingAddresses->removeElement($clientAddress);
    }

    /** @param ArrayCollection<int, ClientShippingAddressInterface> $shippingAddresses */
    public function setShippingAddresses(ArrayCollection $shippingAddresses): void
    {
        $this->shippingAddresses = $shippingAddresses;
    }

    public function hasShippingAddress(): bool
    {
        return count($this->shippingAddresses) > 0;
    }

    public function getDefaultShippingAddress(): ?ClientShippingAddressInterface
    {
        $defaultShippingAddress = $this->shippingAddresses->first();

        return $defaultShippingAddress === false ? null : $defaultShippingAddress;
    }

    public function getShopUser(): ?ShopUserInterface
    {
        return $this->shopUser;
    }

    public function setShopUser(?ShopUserInterface $shopUser): void
    {
        $this->shopUser = $shopUser;
    }

    public function __toString(): string
    {
        return $this->getPersonalDetails()->getName();
    }
}
