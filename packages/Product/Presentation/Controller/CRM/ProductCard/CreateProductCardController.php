<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductCard;

use Impexta\Product\Domain\Factory\ProductCardFactory;
use Impexta\Product\Infrastructure\Repository\ProductCardRepository;
use Impexta\Product\Presentation\Form\Model\ProductCardModel;
use Impexta\Product\Presentation\Form\Type\ProductCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateProductCardController extends AbstractController
{
    private ProductCardFactory $productCardFactory;
    private ProductCardRepository $productCardRepository;

    public function __construct(
        ProductCardFactory $productCardFactory,
        ProductCardRepository $productCardRepository
    ) {
        $this->productCardFactory = $productCardFactory;
        $this->productCardRepository = $productCardRepository;
    }

    /** @Route("produktova-karta/vytvorit", name="product_crm_product_card_create") */
    public function __invoke(Request $request): Response
    {
        $model = ProductCardModel::createEmpty();

        $form = $this->createForm(ProductCardType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productCard = $this->productCardFactory->create($model);

            $this->productCardRepository->save($productCard);
            $this->addFlash('success', 'Produktová karta byla vytvořena');

            return $this->redirectToRoute('product_crm_product_card_detail', [
                'id' => $productCard->getId(),
            ]);
        }

        return $this->render('@product/CRM/product_card/product_card_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
