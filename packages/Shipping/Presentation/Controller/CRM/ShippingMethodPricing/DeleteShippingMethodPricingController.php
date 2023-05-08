<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Controller\CRM\ShippingMethodPricing;

use Impexta\Shipping\Domain\Entity\ShippingMethodPricing;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class DeleteShippingMethodPricingController extends AbstractController
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(
        ShippingMethodPricingRepository $shippingMethodPricingRepository
    ) {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /**
     * @Route("/doprava/cenik/{id}/smazat", name="shipping_crm_delete_shipping_method_pricing")
     */
    public function __invoke(ShippingMethodPricing $pricing): Response
    {
        $this->shippingMethodPricingRepository->removeAndSave($pricing);
        $this->addFlash('warning', 'Cena dopravy byla smazána.');

        return $this->redirectToRoute('shipping_crm_list_shipping_method_pricing');
    }
}
