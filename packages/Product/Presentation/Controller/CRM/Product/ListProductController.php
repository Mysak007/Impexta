<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Product;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Infrastructure\Security\ProductCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** @Route("produkty", name="product_crm_product_list") */
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(ProductCrudVoter::ACCESS, Product::class);

        $products = $this->productRepository->findAll();

        return $this->render(
            '@product/CRM/product/product_list.html.twig',
            [
                'products' => $products,
                'product' => Product::class,
            ]
        );
    }
}
