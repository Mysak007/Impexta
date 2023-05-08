<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Car\Infrastructure\Model\FilterModelFactory;
use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

final class ProductListController extends AbstractController
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    private PaginatorInterface $paginator;
    private FilterModelFactory $filterModelFactory;

    /** @var Breadcrumbs<Breadcrumbs> */
    private Breadcrumbs $breadcrumbs;

    /** @param Breadcrumbs<Breadcrumbs> $breadcrumbs */
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        PaginatorInterface $paginator,
        Breadcrumbs $breadcrumbs,
        FilterModelFactory $filterModelFactory
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
        $this->breadcrumbs = $breadcrumbs;
        $this->filterModelFactory = $filterModelFactory;
    }

    /**
     * @Route("/produkty/{categorySlug}", name="product_eshop_product_list")
     * @ParamConverter("category", options={"mapping": {"categorySlug": "slug"}})
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function __invoke(Request $request, ?Category $category = null, ?string $categorySlug = null): Response
    {
        $this->breadcrumbs->addItem('Naše nabídka');

        $filterModel = $this->filterModelFactory->createFromSession($request->getSession());

        $products = $this->productRepository->findProductsForEshop($filterModel);

        if ($category) {
            foreach ($category->getParents() as $parent) {
                $this->breadcrumbs->addRouteItem(
                    $parent->getName(),
                    'product_eshop_product_list',
                    [
                        'categorySlug' => $parent->getSlug(),
                    ]
                );
            }

            $parent = $category->getParent();

            if (! $parent) {
                $products = $this->productRepository->getQueryForProductsByParentCategory($category, $filterModel);
            }

            if ($parent) {
                $products = $this->productRepository->getQueryForProductsByCategory($category, $filterModel);
            }
        }

        $page = $request->query->getInt('page', 1);

        $pagination = $this->paginator->paginate(
            $products,
            $page,
            6
        );

        return $this->render(
            '@product/Eshop/Product/product_list.html.twig',
            [
                'categories' => $this->categoryRepository->findAllCategoriesWithoutParent(),
                'pagination' => $pagination,
                'category' => $category,
                'breadcrumbs' => $this->breadcrumbs,
            ]
        );
    }
}
