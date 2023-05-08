<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductCard;

use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Infrastructure\Repository\ProductCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteProductCardController extends AbstractController
{
    private ProductCardRepository $productCardRepository;

    public function __construct(ProductCardRepository $productCardRepository)
    {
        $this->productCardRepository = $productCardRepository;
    }

    /** @Route("produktova-karta/{id}/odstranit", name="product_crm_product_card_delete") */
    public function __invoke(ProductCard $productCard): Response
    {
        $this->productCardRepository->removeAndSave($productCard);
        $this->addFlash('success', 'Produktová karta byla odstraněna');

        return $this->redirectToRoute('product_crm_product_card_list');
    }
}
