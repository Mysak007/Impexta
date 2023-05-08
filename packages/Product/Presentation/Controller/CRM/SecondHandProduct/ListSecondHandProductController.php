<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\SecondHandProduct;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Infrastructure\Repository\SecondHandProductRepository;
use Impexta\Product\Infrastructure\Security\SecondHandProductCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListSecondHandProductController extends AbstractController
{
    private SecondHandProductRepository $productRepository;

    public function __construct(SecondHandProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** @Route("bazar/produkty", name="product_crm_second_hand_product_list") */
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(SecondHandProductCrudVoter::ACCESS, SecondHandProduct::class);

        $products = $this->productRepository->findAll();

        return $this->render(
            '@product/CRM/second_hand_product/second_hand_product_list.html.twig',
            [
                'products' => $products,
                'product' => SecondHandProduct::class,
            ]
        );
    }
}
