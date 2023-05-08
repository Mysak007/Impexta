<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Category;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteCategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("kategorie-produktu/{id}/odstranit", name="product_crm_category_delete") */
    public function __invoke(Category $category): Response
    {
        $this->categoryRepository->removeAndSave($category);
        $this->addFlash('success', 'Kategorie byla odstraněna');

        return $this->redirectToRoute('product_crm_category_list');
    }
}
