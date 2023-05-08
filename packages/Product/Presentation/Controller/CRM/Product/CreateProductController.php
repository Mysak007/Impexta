<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Product;

use Impexta\Product\Domain\Entity\Product;
use Impexta\Product\Domain\Factory\ProductFactory;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Infrastructure\Security\ProductCrudVoter;
use Impexta\Product\Infrastructure\Service\BulkUploadedImagesService;
use Impexta\Product\Presentation\Form\Model\ProductModel;
use Impexta\Product\Presentation\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateProductController extends AbstractController
{
    private ProductFactory $productFactory;
    private ProductRepository $productRepository;
    private BulkUploadedImagesService $bulkUploadedImagesService;

    public function __construct(
        ProductFactory $productFactory,
        ProductRepository $productRepository,
        BulkUploadedImagesService $bulkUploadedImagesService
    ) {
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->bulkUploadedImagesService = $bulkUploadedImagesService;
    }

    /**
     * @Route("produkty/vytvorit", name="product_crm_product_create")
     */
    public function __invoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted(ProductCrudVoter::CREATE, Product::class);

        /** @var ProductModel $productModel */
        $productModel = ProductModel::createEmpty();
        $form = $this->createForm(ProductType::class, $productModel, [
            'validation_groups' => [
                'Default',
                'create',
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $this->productFactory->create($productModel);
            // images uploaded in bulk (outside of ProductImages collection)
            $images = $form->get('uploadedImages')->getData();
            $this->bulkUploadedImagesService->addUploadedImagesToProduct($images, $product);
            $this->productRepository->save($product);
            $this->addFlash('success', 'Produkt byl úspěšně vytvořen');

            return $this->redirectToRoute('product_crm_product_detail', ['id' => $product->getId()]);
        }

        return $this->render(
            '@product/CRM/product/product_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
