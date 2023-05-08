<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Factory;

use App\Eshop\Enum\Country;
use Impexta\Product\Infrastructure\XMLFeedGenerator\Model\XmlFeedProductShippingModel;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;

/** @SuppressWarnings(PHPMD.LongVariable) */
final class XmlFeedProductShippingModelFactory
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(ShippingMethodPricingRepository $shippingMethodPricingRepository)
    {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /** @return array<int,XmlFeedProductShippingModel> */
    public function create(): array
    {
        $shippings = [];

        foreach (Country::values() as $country) {
            foreach (ShippingMethod::values() as $shipping) {
                $shippingPricing = $this->shippingMethodPricingRepository->findOneBy(
                    ['shippingMethod' => ShippingMethod::get($shipping),
                        'country' => Country::get($country),
                    ]
                );

                if (!$shippingPricing) {
                    continue;
                }

                $shippings[] = new XmlFeedProductShippingModel(
                    ShippingMethod::get($shipping),
                    $shippingPricing->getPrice(),
                    $shippingPricing->getCashOnDeliveryFee()
                );
            }
        }

        return $shippings;
    }
}
