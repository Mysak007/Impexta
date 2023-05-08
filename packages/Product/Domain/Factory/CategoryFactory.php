<?php

declare(strict_types=1);

namespace Impexta\Product\Domain\Factory;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Impexta\Product\Presentation\Form\Model\CategoryModel;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class CategoryFactory
{
    public function create(CategoryModel $categoryModel): CategoryInterface
    {
        $slugger = new AsciiSlugger();

        $category = new Category(
            $categoryModel->name,
            $slugger->slug($categoryModel->name)->toString()
        );

        $category->setParent($categoryModel->parent);

        return $category;
    }
}
