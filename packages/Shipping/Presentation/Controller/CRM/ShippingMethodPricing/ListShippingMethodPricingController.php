<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Controller\CRM\ShippingMethodPricing;

use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class ListShippingMethodPricingController extends AbstractController
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(
        ShippingMethodPricingRepository $shippingMethodPricingRepository
    ) {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /**
     * @Route("/cenik-dopravy", name="shipping_crm_list_shipping_method_pricing")
     */

    public function __invoke(): Response
    {
        $pricings = $this->shippingMethodPricingRepository->findAll();

        return $this->render(
            '@shipping/CRM/shipping_method_pricing/shipping_method_pricing_list.twig',
            [
                'pricings' => $pricings,
            ]
        );
    }
}
