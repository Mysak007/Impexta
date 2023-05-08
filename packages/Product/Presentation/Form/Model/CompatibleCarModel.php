<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Product\Domain\Entity\CompatibleCarInterface;
use Impexta\Product\Domain\Entity\ProductCard;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CompatibleCarModel implements ModelInterface
{
    public ?ProductCard $productCard = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, CarInterface>
     */
    public Collection $cars;

    /** @param CompatibleCarInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = new self();

        $model->productCard = $entity->getProductCard();
        $model->cars = new ArrayCollection();
        $model->cars[] = $entity->getCar();

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
