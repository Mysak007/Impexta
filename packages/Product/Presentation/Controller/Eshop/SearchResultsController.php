<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\Product\Presentation\Form\Type\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

final class SearchResultsController extends AbstractController
{
    private PaginatorInterface $paginator;

    /** @var Breadcrumbs<Breadcrumbs> */
    private Breadcrumbs $breadcrumbs;
    private ProductRepository $productRepository;

    /** @param Breadcrumbs<Breadcrumbs> $breadcrumbs */
    public function __construct(
        PaginatorInterface $paginator,
        Breadcrumbs $breadcrumbs,
        ProductRepository $productRepository
    ) {
        $this->paginator = $paginator;
        $this->breadcrumbs = $breadcrumbs;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/hledat/{searchQuery}/{page}", name="eshop_search")
     */
    public function __invoke(Request $request, string $searchQuery = '', int $page = 1): Response
    {
        $this->breadcrumbs->addItem('Vyhledávání');

        $searchForm = $this->createForm(SearchType::class, ['query' => $searchQuery]);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('eshop_search', ['searchQuery' => $searchForm->get('query')->getData()]);
        }

        $products = $this->productRepository->getQueryForProducts($searchQuery);

        $pagination = $this->paginator->paginate(
            $products,
            $page,
            9
        );

        return $this->render(
            'Eshop/search.html.twig',
            [
                'products' => $products,
                'pagination' => $pagination,
                'breadcrumbs' => $this->breadcrumbs,
                'search_form' => $searchForm->createView(),
            ]
        );
    }
}
