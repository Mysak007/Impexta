<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductPrice;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Factory\ProductPriceFactory;
use Impexta\Product\Infrastructure\Repository\ProductPriceRepository;
use Impexta\Product\Presentation\Form\Model\ProductPriceModel;
use Impexta\Product\Presentation\Form\Type\ProductPriceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateProductPriceController extends AbstractController
{
    private ProductPriceFactory $productPriceFactory;
    private ProductPriceRepository $productPriceRepository;

    public function __construct(
        ProductPriceFactory $productPriceFactory,
        ProductPriceRepository $productPriceRepository
    ) {
        $this->productPriceFactory = $productPriceFactory;
        $this->productPriceRepository = $productPriceRepository;
    }

    /** @Route("produkt/{id}/cena/vytvorit", name="product_crm_product_price_create", requirements={"id"="\d+"}) */
    public function __invoke(Product $product, Request $request): Response
    {
        $productPriceModel = ProductPriceModel::createEmpty();
        $form = $this->createForm(ProductPriceType::class, $productPriceModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $productPrice = $this->productPriceFactory->create($productPriceModel, $product);

             $this->productPriceRepository->save($productPrice);

             $this->addFlash('success', 'Cena produktu byla úspešně vytvořena');

             return $this->redirectToRoute('product_crm_product_detail', ['id' => $product->getId()]);
        }

        return $this->render('@product/CRM/product_price/product_price_create.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
