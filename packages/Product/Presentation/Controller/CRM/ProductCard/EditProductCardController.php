<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductCard;

use Impexta\Product\Domain\Entity\ProductCard;
use Impexta\Product\Infrastructure\Mapper\ProductCardMapper;
use Impexta\Product\Infrastructure\Repository\ProductCardRepository;
use Impexta\Product\Presentation\Form\Model\ProductCardModel;
use Impexta\Product\Presentation\Form\Type\ProductCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditProductCardController extends AbstractController
{
    private ProductCardMapper $productCardMapper;
    private ProductCardRepository $productCardRepository;

    public function __construct(
        ProductCardMapper $productCardMapper,
        ProductCardRepository $productCardRepository
    ) {
        $this->productCardMapper = $productCardMapper;
        $this->productCardRepository = $productCardRepository;
    }

    /** @Route("produktova-karta/{id}/upravit", name="product_crm_product_card_edit") */
    public function __invoke(ProductCard $productCard, Request $request): Response
    {
        $model = ProductCardModel::createFromEntity($productCard);

        $form = $this->createForm(ProductCardType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productCardMapper->mapFromModel($model, $productCard);

            $this->productCardRepository->save($productCard);
            $this->addFlash('success', 'Produktová karta byla úspěšně aktualizována');

            return $this->redirectToRoute('product_crm_product_card_detail', ['id' => $productCard->getId()]);
        }

        return $this->render('@product/CRM/product_card/product_card_edit.html.twig', [
            'productCard' => $productCard,
            'form' => $form->createView(),
        ]);
    }
}
