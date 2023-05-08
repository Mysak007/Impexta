<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\SecondHandProduct;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Infrastructure\Mapper\SecondHandProductMapper;
use Impexta\Product\Infrastructure\Repository\SecondHandProductRepository;
use Impexta\Product\Infrastructure\Security\SecondHandProductCrudVoter;
use Impexta\Product\Presentation\Form\Model\SecondHandProductModel;
use Impexta\Product\Presentation\Form\Type\SecondHandProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditSecondHandProductController extends AbstractController
{
    private SecondHandProductRepository $productRepository;
    private SecondHandProductMapper $productMapper;

    public function __construct(
        SecondHandProductRepository $productRepository,
        SecondHandProductMapper $productMapper
    ) {
        $this->productRepository = $productRepository;
        $this->productMapper = $productMapper;
    }

    /** @Route("bazar/{id}/upravit", name="product_crm_second_hand_product_edit", requirements={"id"="\d+"}) */
    public function __invoke(SecondHandProduct $product, Request $request): Response
    {
        $this->denyAccessUnlessGranted(SecondHandProductCrudVoter::EDIT, $product);

        /** @var SecondHandProductModel $model */
        $model = SecondHandProductModel::createFromEntity($product);
        $form = $this->createForm(SecondHandProductType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productMapper->mapFromModel($model, $product);

            $this->productRepository->save($product);
            $this->addFlash('success', 'Produkt byl aktualizován');

            return $this->redirectToRoute('product_crm_second_hand_product_detail', ['id' => $product->getId()]);
        }

        return $this->render(
            '@product/CRM/second_hand_product/second_hand_product_edit.html.twig',
            [
                'form' => $form->createView(),
                'product' => $product,
            ]
        );
    }
}
