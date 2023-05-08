<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductCard;

use Impexta\Product\Infrastructure\Repository\ProductCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListProductCardController extends AbstractController
{
    private ProductCardRepository $productCardRepository;

    public function __construct(ProductCardRepository $productCardRepository)
    {
        $this->productCardRepository = $productCardRepository;
    }

    /** @Route("produktove-karty", name="product_crm_product_card_list") */
    public function __invoke(): Response
    {
        $productCards = $this->productCardRepository->findAll();

        return $this->render('@product/CRM/product_card/product_card_list.html.twig', [
            'productCards' => $productCards,
        ]);
    }
}
