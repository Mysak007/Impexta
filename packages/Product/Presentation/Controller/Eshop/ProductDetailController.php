<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

final class ProductDetailController extends AbstractController
{
    /** @var Breadcrumbs<Breadcrumbs> */
    private Breadcrumbs $breadcrumbs;
    private ProductRepository $productRepository;

    /**
     * @param Breadcrumbs<Breadcrumbs> $breadcrumbs
     */
    public function __construct(
        Breadcrumbs $breadcrumbs,
        ProductRepository $productRepository
    ) {
        $this->breadcrumbs = $breadcrumbs;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/produkty/{categorySlug}/{productSlug}/{productId}", name="product_eshop_product_detail")
     * @Entity("product", expr="repository.find(productId)")
     */
    public function __invoke(Product $product): Response
    {
        $this->breadcrumbs->addItem('Naše nabídka');

        foreach ($product->getProductCard()->getCategory()->getParents() as $parent) {
            $this->breadcrumbs->addRouteItem(
                $parent->getName(),
                'product_eshop_product_list',
                [
                    'categorySlug' => $parent->getSlug(),
                ]
            );
        }

        $this->breadcrumbs->addItem($product->getName());

        $productCard = $product->getProductCard();

        $alternativeProducts = $this->productRepository->findAlternativeProductsForEshop($productCard);

        return $this->render(
            '@product/Eshop/Product/product_detail.html.twig',
            [
                'product' => $product,
                'breadcrumbs' => $this->breadcrumbs,
                'alternativeProducts' => $alternativeProducts,
            ]
        );
    }
}
