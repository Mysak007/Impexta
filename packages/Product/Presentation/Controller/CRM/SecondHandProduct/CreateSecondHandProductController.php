<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\SecondHandProduct;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Domain\Factory\SecondHandProductFactory;
use Impexta\Product\Infrastructure\Repository\SecondHandProductRepository;
use Impexta\Product\Infrastructure\Security\SecondHandProductCrudVoter;
use Impexta\Product\Presentation\Form\Model\SecondHandProductModel;
use Impexta\Product\Presentation\Form\Type\SecondHandProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateSecondHandProductController extends AbstractController
{
    private SecondHandProductFactory $productFactory;
    private SecondHandProductRepository $productRepository;

    public function __construct(
        SecondHandProductFactory $productFactory,
        SecondHandProductRepository $productRepository
    ) {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("bazar/vytvorit", name="product_crm_second_hand_product_create")
     */
    public function __invoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted(SecondHandProductCrudVoter::CREATE, SecondHandProduct::class);

        /** @var SecondHandProductModel $productModel */
        $productModel = SecondHandProductModel::createEmpty();
        $form = $this->createForm(SecondHandProductType::class, $productModel, [
            'validation_groups' => [
                'Default',
                'create',
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $this->productFactory->create($productModel);

            $this->productRepository->save($product);
            $this->addFlash('success', 'Produkt byl úspěšně vytvořen');

            return $this->redirectToRoute('product_crm_second_hand_product_detail', ['id' => $product->getId()]);
        }

        return $this->render(
            '@product/CRM/second_hand_product/second_hand_product_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
