<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Product;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Infrastructure\Mapper\ProductMapper;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Infrastructure\Security\ProductCrudVoter;
use Impexta\Product\Infrastructure\Service\BulkUploadedImagesService;
use Impexta\Product\Infrastructure\Service\CheckProductBindingsService;
use Impexta\Product\Presentation\Form\Model\ProductModel;
use Impexta\Product\Presentation\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private ProductMapper $productMapper;
    private CheckProductBindingsService $checkProductBindingsService;
    private BulkUploadedImagesService $bulkUploadedImagesService;

    public function __construct(
        ProductRepository $productRepository,
        ProductMapper $productMapper,
        CheckProductBindingsService $checkProductBindingsService,
        BulkUploadedImagesService $bulkUploadedImagesService
    ) {
        $this->productRepository = $productRepository;
        $this->productMapper = $productMapper;
        $this->checkProductBindingsService = $checkProductBindingsService;
        $this->bulkUploadedImagesService = $bulkUploadedImagesService;
    }

    /** @Route("produkt/{id}/upravit", name="product_crm_product_edit", requirements={"id"="\d+"}) */
    public function __invoke(Product $product, Request $request): Response
    {
        $this->denyAccessUnlessGranted(ProductCrudVoter::EDIT, $product);

        /** @var ProductModel $model */
        $model = ProductModel::createFromEntity($product);
        $form = $this->createForm(ProductType::class, $model);

        $allowRemove = $this->checkProductBindingsService->isSafeToDeleteProduct($product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productMapper->mapFromModel($model, $product);
            // images uploaded in bulk (outside of ProductImages collection)
            $images = $form->get('uploadedImages')->getData();
            $this->bulkUploadedImagesService->addUploadedImagesToProduct($images, $product);
            $this->productRepository->save($product);
            $this->addFlash('success', 'Produkt byl aktualizován');

            return $this->redirectToRoute('product_crm_product_detail', ['id' => $product->getId()]);
        }

        return $this->render(
            '@product/CRM/product/product_edit.html.twig',
            [
                'form' => $form->createView(),
                'product' => $product,
                'allowRemove' => $allowRemove,
            ]
        );
    }
}
