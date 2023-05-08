<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\ProductPrice;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Entity\ProductPrice;
use Impexta\Product\Infrastructure\Mapper\ProductPriceMapper;
use Impexta\Product\Infrastructure\Repository\ProductPriceRepository;
use Impexta\Product\Presentation\Form\Model\ProductPriceModel;
use Impexta\Product\Presentation\Form\Type\ProductPriceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditProductPriceController extends AbstractController
{
    private ProductPriceMapper $productPriceMapper;
    private ProductPriceRepository $productPriceRepository;

    public function __construct(
        ProductPriceMapper $productPriceMapper,
        ProductPriceRepository $productPriceRepository
    ) {
        $this->productPriceMapper = $productPriceMapper;
        $this->productPriceRepository = $productPriceRepository;
    }

    /** @Route("produkt/{id}/cena/{priceId}/upravit", name="product_crm_product_price_edit", requirements={"id"="\d+"})
     * @ParamConverter("productPrice", options={"id" = "priceId"})
     */
    public function __invoke(Request $request, Product $product, ProductPrice $productPrice): Response
    {
        $model = ProductPriceModel::createFromEntity($productPrice);
        $form = $this->createForm(ProductPriceType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productPriceMapper->mapFromModel($productPrice, $model);

            $this->productPriceRepository->save($productPrice);
            $this->addFlash('success', 'Cena produktu byla aktualizována');

            return $this->redirectToRoute('product_crm_product_detail', ['id' => $product->getId()]);
        }

        return $this->render('@product/CRM/product_price/product_price_edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'productPrice' => $productPrice,
            ]);
    }
}
