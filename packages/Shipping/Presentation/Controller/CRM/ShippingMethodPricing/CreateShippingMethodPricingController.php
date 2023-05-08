<?php

declare(strict_types=1);

namespace Impexta\Shipping\Presentation\Controller\CRM\ShippingMethodPricing;

use Impexta\Shipping\Domain\Factory\ShippingMethodPricingFactory;
use Impexta\Shipping\Infrastructure\Repository\ShippingMethodPricingRepository;
use Impexta\Shipping\Presentation\Form\Model\ShippingMethodPricingModel;
use Impexta\Shipping\Presentation\Form\Type\ShippingMethodPricingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings(PHPMD.LongVariable) */

final class CreateShippingMethodPricingController extends AbstractController
{
    private ShippingMethodPricingFactory $shippingMethodPricingFactory;
    private ShippingMethodPricingRepository $shippingMethodPricingRepository;

    public function __construct(
        ShippingMethodPricingFactory $shippingMethodPricingFactory,
        ShippingMethodPricingRepository $shippingMethodPricingRepository
    ) {
        $this->shippingMethodPricingFactory = $shippingMethodPricingFactory;
        $this->shippingMethodPricingRepository = $shippingMethodPricingRepository;
    }

    /**
     * @Route("/doprava/cenik/vytvorit", name="shipping_crm_create_shipping_method_pricing")
     */
    public function __invoke(Request $request): Response
    {
        $pricingModel = ShippingMethodPricingModel::createEmpty();
        $form = $this->createForm(ShippingMethodPricingType::class, $pricingModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pricing = $this->shippingMethodPricingFactory->create($pricingModel);
            $this->shippingMethodPricingRepository->save($pricing);
            $this->addFlash('success', 'Cena dopravy byla vytvořena.');

            return $this->redirectToRoute('shipping_crm_list_shipping_method_pricing');
        }

        return $this->render(
            '@shipping/CRM/shipping_method_pricing/shipping_method_pricing_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
