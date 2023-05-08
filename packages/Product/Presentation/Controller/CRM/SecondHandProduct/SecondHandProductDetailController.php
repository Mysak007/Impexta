<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\SecondHandProduct;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Infrastructure\Security\SecondHandProductCrudVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SecondHandProductDetailController extends AbstractController
{
    /** @Route("bazar/{id}", name="product_crm_second_hand_product_detail", requirements={"id"="\d+"}) */
    public function __invoke(SecondHandProduct $product): Response
    {
        $this->denyAccessUnlessGranted(SecondHandProductCrudVoter::VIEW, $product);

        return $this->render(
            '@product/CRM/second_hand_product/second_hand_product_detail.html.twig',
            [
                'product' => $product,
            ]
        );
    }
}
