<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Category;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Infrastructure\Mapper\CategoryMapper;
use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Impexta\Product\Presentation\Form\Model\CategoryModel;
use Impexta\Product\Presentation\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditCategoryController extends AbstractController
{
    private CategoryMapper $categoryMapper;
    private CategoryRepository $categoryRepository;

    public function __construct(
        CategoryMapper $categoryMapper,
        CategoryRepository $categoryRepository
    ) {
        $this->categoryMapper = $categoryMapper;
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("kategorie-produktu/{id}/upravit", name="product_crm_category_edit") */
    public function __invoke(Category $category, Request $request): Response
    {
        $model = CategoryModel::createFromEntity($category);
        $form = $this->createForm(CategoryType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryMapper->mapFromModel($model, $category);
            $this->categoryRepository->save($category);

            $this->addFlash('success', 'Kategorie byla úspěšně aktualizována');

            return $this->redirectToRoute('product_crm_category_list');
        }

        return $this->render('@product/CRM/category/category_edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'categories' => $this->categoryRepository->findCategoriesWithSubcategoryCount($category->getId()),
        ]);
    }
}
