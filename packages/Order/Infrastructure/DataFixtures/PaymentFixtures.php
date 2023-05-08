<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Order\Domain\Entity\OnlinePayment;
use Impexta\Order\Domain\Entity\Payment;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Order\Domain\Enum\PaymentState;
use Money\Currency;
use Money\Money;

final class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var OnlinePayment $onlinePayment */
        $onlinePayment = $this->getReference('onlinePayment');
        $price = new Money(4999, new Currency('CZK'));

        $payment = new Payment(
            PaymentState::get(PaymentState::NEW),
            PaymentMethod::get(PaymentMethod::ONLINE),
            $price
        );

        $payment->setOnlinePayment($onlinePayment);

        $manager->persist($payment);
        $manager->flush();

        $this->addReference('payment', $payment);
    }

    /**
     * @return array <class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            OnlinePaymentFixtures::class,
        ];
    }
}
