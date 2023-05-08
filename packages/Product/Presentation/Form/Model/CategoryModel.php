<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Impexta\Product\Domain\Entity\Category;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CategoryModel implements ModelInterface
{
    public ?Category $parent = null;

    /** @Assert\Length(max=255, maxMessage="Název nesmí být delsí než 255 znaků") */
    public string $name;

    /** @param CategoryInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = new self();

        $model->parent = $entity->getParent();
        $model->name = $entity->getName();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
