<?php

declare(strict_types=1);

namespace Impexta\Shipping\Domain\Factory;

use Impexta\Shipping\Domain\Entity\ShippingMethodPricing;
use Impexta\Shipping\Presentation\Form\Model\ShippingMethodPricingModel;

final class ShippingMethodPricingFactory
{
    public function create(ShippingMethodPricingModel $pricingModel): ShippingMethodPricing
    {
        $shippingMethodPricing = new ShippingMethodPricing(
            $pricingModel->name,
            $pricingModel->shippingMethod,
            $pricingModel->country,
            $pricingModel->price,
            $pricingModel->overWeightPrice,
            $pricingModel->cashOnDeliveryFee
        );
        $shippingMethodPricing->setDescription($pricingModel->description);
        $shippingMethodPricing->setOverWeightLimit($pricingModel->overWeightLimit);

        return $shippingMethodPricing;
    }
}
