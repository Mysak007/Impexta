<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Mapper;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Presentation\Form\Model\CategoryModel;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class CategoryMapper
{
    public function mapFromModel(CategoryModel $model, Category $category): void
    {
        $slugger = new AsciiSlugger();
        $category->setName($model->name);
        $category->setSlug($slugger->slug($model->name)->toString());
        $category->setParent($model->parent);
    }
}
