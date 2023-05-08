<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Client\Infrastructure\DataFixtures\ClientCarFixtures;
use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\Inquiry\Domain\Entity\InquiryItemOffer;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\DataFixtures\ProductCardFixtures;
use Impexta\Product\Infrastructure\DataFixtures\ProductFixtures;
use Money\Currency;
use Money\Money;

final class InquiryRequestsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var ArrayCollection<int, InquiryInterface> $inquiries */
        $inquiries = new ArrayCollection();

        for ($iteration = 0; $iteration <= 4; ++$iteration) {
            /** @var InquiryInterface $inquiry */
            $inquiry = $this->getReference('inquiry' . $iteration);
            $inquiries->add($inquiry);
        }

        /** @var ArrayCollection<int, InquiryItemRequestInterface> $inquiryItemRequests */
        $inquiryItemRequests = new ArrayCollection();

        foreach ($inquiries as $inquiry) {
            /** @var ProductCardInterface $productCard */
            $productCard = $this->getReference('productCardFront');

            $itemRequest = new InquiryItemRequest(
                $inquiry,
                $productCard,
                random_int(1, 3),
            );
            /** @var ClientCarInterface $clientCar */
            $clientCar = $this->getReference('clientCar' . random_int(0, 4));
            $itemRequest->setClientCar($clientCar);
            $inquiry->addItemRequest($itemRequest);

            /** @var ProductInterface $product */
            $product = $this->getReference('product' . random_int(0, 9));
            $price = new Money(650000, new Currency('CZK'));
            $itemOffer = new InquiryItemOffer(
                $itemRequest,
                $product,
                $price,
            );
            $itemRequest->addItemOffer($itemOffer);

            $inquiryItemRequests->add($itemRequest);
            $manager->persist($itemRequest);
            $manager->persist($itemOffer);
        }

        $manager->flush();

        $iteration = 0;

        foreach ($inquiryItemRequests as $inquiryItemRequest) {
            $this->addReference('inquiryItemRequest' . $iteration, $inquiryItemRequest);
            ++$iteration;
        }
    }

    /**
     * @return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            InquiryFixtures::class,
            ProductCardFixtures::class,
            ClientCarFixtures::class,
            ProductFixtures::class,
        ];
    }
}
