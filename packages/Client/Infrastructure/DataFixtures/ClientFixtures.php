<?php

declare(strict_types=1);

namespace Impexta\Client\Infrastructure\DataFixtures;

use App\Eshop\Enum\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientAddress;
use Impexta\Client\Domain\Entity\ClientBankAccount;
use Impexta\Client\Domain\Entity\ClientBillingAddress;
use Impexta\Client\Domain\Entity\ClientContactDetails;
use Impexta\Client\Domain\Entity\ClientPersonalDetails;
use Impexta\Client\Domain\Entity\ClientShippingAddress;
use Impexta\Client\Domain\Enum\ClientGroup;
use Microshop\SymfonySurvivalKit\Enum\Bank;
use Money\Currency;

final class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $personalDetails = new ClientPersonalDetails();
        $personalDetails->setFirstName('Client');
        $personalDetails->setLastName('Eastwood');
        $personalDetails->setCompanyName('Moje firma s.r.o.');
        $personalDetails->setTaxId('26165031');
        $personalDetails->setVatId('CZ2616531');

        $contactDetails = new ClientContactDetails(
            'client@example.com',
            '+420123456789'
        );

        $bankAccount = new ClientBankAccount(
            Bank::get(Bank::SPARKASSE),
            '123456789'
        );

        $billingAddressDetails = new ClientAddress(
            'Client\'s Address'
        );
        $billingAddressDetails->setCode('123456');
        $billingAddressDetails->setLatitude('50.04024057348884');
        $billingAddressDetails->setLongitude('15.769529871252942');
        $billingAddressDetails->setStreet('Sukova třída');
        $billingAddressDetails->setHouseNumber('1735');
        $billingAddressDetails->setCity('Pardubice');
        $billingAddressDetails->setZipCode('53002');
        $billingAddressDetails->setDistrict('Zelené Předměstí');
        $billingAddressDetails->setRegion('Pardubický kraj');
        $billingAddressDetails->setCountry('Česká Republika');

        $shippingAddressDetails = new ClientAddress(
            'Client\'s Address'
        );
        $shippingAddressDetails->setCode('123456');
        $shippingAddressDetails->setLatitude('50.04024057348884');
        $shippingAddressDetails->setLongitude('15.769529871252942');
        $shippingAddressDetails->setStreet('Sukova třída');
        $shippingAddressDetails->setHouseNumber('1735');
        $shippingAddressDetails->setCity('Pardubice');
        $shippingAddressDetails->setZipCode('53002');
        $shippingAddressDetails->setDistrict('Zelené Předměstí');
        $shippingAddressDetails->setRegion('Pardubický kraj');
        $shippingAddressDetails->setCountry('Česká Republika');

        $clientBillingAddress = new ClientBillingAddress(
            $billingAddressDetails
        );

        $group = ClientGroup::get(ClientGroup::B2B);
        $currency = new Currency('CZK');
        $country = Country::get(Country::CZECHIA);

        $client = new Client(
            $personalDetails,
            $contactDetails,
            $clientBillingAddress,
            $group,
            $currency,
            $country,
            0
        );

        $client->setBankAccount($bankAccount);

        $clientShippingAddress = new ClientShippingAddress(
            $shippingAddressDetails,
            $client
        );

        $client->addShippingAddress($clientShippingAddress);

        $manager->persist($client);
        $manager->persist($clientShippingAddress);
        $manager->flush();

        $this->addReference('client', $client);
        $this->addReference('clientBillingAddress', $clientBillingAddress);
        $this->addReference('clientShippingAddress', $clientShippingAddress);
    }
}
