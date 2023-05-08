<?php

declare(strict_types=1);

namespace Impexta\Client\Domain\Entity;

use App\Eshop\Enum\Country;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Client\Domain\Enum\ClientGroup;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Money\Currency;

interface ClientInterface extends EntityInterface
{
    public function getPersonalDetails(): ClientPersonalDetailsInterface;

    public function getContactDetails(): ClientContactDetailsInterface;

    public function getBankAccount(): ?ClientBankAccountInterface;

    public function getBillingAddress(): ClientBillingAddressInterface;

    public function getClientGroup(): ClientGroup;

    public function setClientGroup(ClientGroup $group): void;

    public function setBankAccount(?ClientBankAccountInterface $bankAccount): void;

    public function getCurrency(): Currency;

    public function setCurrency(Currency $currency): void;

    public function getCountry(): Country;

    public function setCountry(Country $country): void;

    public function getLogo(): ?string;

    public function setLogo(?string $logo): void;

    public function getSale(): int;

    public function setSale(int $sale): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /** @return Collection<int, ClientCarInterface> */
    public function getClientCars(): Collection;

    public function addCar(ClientCarInterface $car): void;

    public function removeCar(ClientCarInterface $car): void;

    /** @param ArrayCollection<int, ClientCarInterface> $cars */
    public function setCars(Collection $cars): void;

    /** @return Collection<int, ClientShippingAddressInterface> */
    public function getShippingAddresses(): Collection;

    public function addShippingAddress(ClientShippingAddressInterface $clientAddress): void;

    public function removeShippingAddress(ClientShippingAddressInterface $clientAddress): void;

    /** @param ArrayCollection<int, ClientShippingAddressInterface> $shippingAddresses */
    public function setShippingAddresses(ArrayCollection $shippingAddresses): void;

    public function hasShippingAddress(): bool;

    public function getDefaultShippingAddress(): ?ClientShippingAddressInterface;

    public function getShopUser(): ?ShopUserInterface;

    public function setShopUser(?ShopUserInterface $shopUser): void;

    public function __toString(): string;
}
