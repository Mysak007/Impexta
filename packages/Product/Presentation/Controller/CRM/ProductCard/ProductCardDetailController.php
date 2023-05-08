<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductCard;

use Impexta\Product\Domain\Entity\ProductCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductCardDetailController extends AbstractController
{
    /** @Route("produktova-karta/{id}", name="product_crm_product_card_detail") */
    public function __invoke(ProductCard $productCard): Response
    {
        return $this->render('@product/CRM/product_card/product_card_detail.html.twig', [
            'productCard' => $productCard,
        ]);
    }
}
