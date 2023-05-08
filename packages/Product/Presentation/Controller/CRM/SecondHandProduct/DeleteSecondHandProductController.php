<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\SecondHandProduct;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Infrastructure\Repository\SecondHandProductRepository;
use Impexta\Product\Infrastructure\Security\SecondHandProductCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteSecondHandProductController extends AbstractController
{
    private SecondHandProductRepository $productRepository;

    public function __construct(SecondHandProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /** @Route("bazar/{id}/odstranit", name="product_crm_second_hand_product_delete") */
    public function __invoke(SecondHandProduct $product): Response
    {
        $this->denyAccessUnlessGranted(SecondHandProductCrudVoter::DELETE, $product);

        $this->productRepository->removeAndSave($product);

        return $this->redirectToRoute('product_crm_second_hand_product_list');
    }
}
