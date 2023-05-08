<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Product;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Infrastructure\Security\ProductCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** @Route("produkt/{id}/odstranit", name="product_crm_product_delete") */
    public function __invoke(Product $product): Response
    {
        $this->denyAccessUnlessGranted(ProductCrudVoter::DELETE, $product);

        $this->productRepository->removeAndSave($product);

        return $this->redirectToRoute('product_crm_product_list');
    }
}
