<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderNavigationCategoriesController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(): Response
    {
        $categories = $this->categoryRepository->findAllCategoriesWithoutParent();

        return $this->render(
            'Eshop/components/_navigation_categories.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }
}
