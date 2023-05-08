<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Category;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SortDownCategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("/{id}/posunout-dolu", name="product_crm_category_sort_down") */
    public function __invoke(Category $category, Request $request): Response
    {
        $category->setPosition($category->getPosition() + 1);
        $this->categoryRepository->save($category);

        /** @var string $referer */
        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }
}
