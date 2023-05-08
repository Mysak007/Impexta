<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductPrice;

use Impexta\Product\Domain\Entity\ProductPrice;
use Impexta\Product\Infrastructure\Repository\ProductPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteProductPriceController extends AbstractController
{
    private ProductPriceRepository $productPriceRepository;

    public function __construct(ProductPriceRepository $productPriceRepository)
    {
        $this->productPriceRepository = $productPriceRepository;
    }

    /** @Route("produkt/{id}/cena/odstranit", name="product_crm_product_price_delete") */
    public function __invoke(ProductPrice $productPrice): RedirectResponse
    {
        $this->productPriceRepository->removeAndSave($productPrice);
        $this->addFlash('danger', 'Cena byla odstraněna');

        return $this->redirectToRoute('product_crm_product_detail', ['id' => $productPrice->getProduct()->getId()]);
    }
}
