<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Controller\CRM\ShippingMethodPricing;

use Impexta\Shipping\Domain\Entity\ShippingMethodPricing;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Impexta\Shipping\Presentation\Form\Model\ShippingMethodPricingModel;
use Impexta\Shipping\Presentation\Form\Type\ShippingMethodPricingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class UpdateShippingMethodPricingController extends AbstractController
{
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(
        ShippingMethodPricingRepository $shippingMethodPricingRepository
    ) {
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /**
     * @Route("/doprava/cenik/{id}/upravit", name="shipping_crm_update_shipping_method_pricing")
     */
    public function __invoke(ShippingMethodPricing $pricing, Request $request): Response
    {
        /** @var ShippingMethodPricingModel $pricingModel */
        $pricingModel = ShippingMethodPricingModel::createFromEntity($pricing);
        $form = $this->createForm(ShippingMethodPricingType::class, $pricingModel, ['is_disabled' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricing->populateFromModel($pricingModel);
            $this->shippingMethodPricingRepository->save($pricing);
            $this->addFlash('success', 'Cena dopravy byla upravena.');

            return $this->redirectToRoute('shipping_crm_list_shipping_method_pricing');
        }

        return $this->render(
            '@shipping/CRM/shipping_method_pricing/shipping_method_pricing_edit.html.twig',
            [
                'form' => $form->createView(),
                'pricing' => $pricing,
            ]
        );
    }
}
