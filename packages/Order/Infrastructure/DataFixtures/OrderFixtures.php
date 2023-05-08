<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Entity\Client;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Domain\Entity\ClientShippingAddressInterface;
use Impexta\Client\Infrastructure\DataFixtures\ClientCarFixtures;
use Impexta\Client\Infrastructure\DataFixtures\ClientFixtures;
use Impexta\Order\Domain\Entity\Order;
use Impexta\Order\Domain\Entity\PaymentInterface;
use Impexta\Order\Domain\Enum\OrderOrigin;
use Impexta\Order\Domain\Enum\OrderState;
use Impexta\Shipping\Domain\Entity\ShipmentInterface;
use Impexta\Shipping\Infrastructure\DataFixtures\ShipmentFixtures;
use Money\Currency;
use Ramsey\Uuid\Uuid;

final class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /**
         * @var Client $client
         */
        $client = $this->getReference('client');

        /** @var ClientCarInterface $clientCar */
        $clientCar = $this->getReference('clientCar');

        /** @var ShipmentInterface $shipment */
        $shipment = $this->getReference('shipment');

        /** @var PaymentInterface $payment */
        $payment = $this->getReference('payment');

        /** @var ClientShippingAddressInterface $shippingAddress */
        $shippingAddress = $this->getReference('clientShippingAddress');
        $token = Uuid::uuid4();
        $currency = new Currency('CZK');

        $order = new Order(
            $client,
            $shipment,
            $payment,
            OrderState::CART,
            OrderOrigin::get(OrderOrigin::CRM),
            '1234',
            $token,
            $currency
        );

        $order->setShippingAddress($shippingAddress);
        $order->setClientCar($clientCar);

        $this->addReference('order', $order);

        $manager->persist($order);

        $manager->flush();
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            ShipmentFixtures::class,
            PaymentFixtures::class,
            ClientCarFixtures::class,
        ];
    }
}
