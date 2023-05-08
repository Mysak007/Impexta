<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\CRM\Category;

use Impexta\Product\Domain\Factory\CategoryFactory;
use Impexta\Product\Infrastructure\Repository\CategoryRepository;
use Impexta\Product\Presentation\Form\Model\CategoryModel;
use Impexta\Product\Presentation\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCategoryController extends AbstractController
{
    private CategoryFactory $categoryFactory;
    private CategoryRepository $categoryRepository;

    public function __construct(
        CategoryFactory $categoryFactory,
        CategoryRepository $categoryRepository
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("kategorie-produktu/vytvorit", name="product_crm_category_create") */
    public function __invoke(Request $request): Response
    {
        $model = CategoryModel::createEmpty();
        $form = $this->createForm(CategoryType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $this->categoryFactory->create($model);
            $this->categoryRepository->save($category);
            $this->addFlash('success', 'Kategorie byla vytvořena');

            return $this->redirectToRoute('product_crm_category_list');
        }

        return $this->render('@product/CRM/category/category_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
