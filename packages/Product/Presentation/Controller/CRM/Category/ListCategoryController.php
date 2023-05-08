<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Category;

use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListCategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("kategorie-produktu", name="product_crm_category_list") */
    public function __invoke(): Response
    {
        $categories = $this->categoryRepository->findCategoriesWithSubcategoryCount();

        return $this->render('@product/CRM/category/category_list.html.twig', [
            'categories' => $categories,
        ]);
    }
}
