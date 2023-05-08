<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Product\Domain\Entity\CategoryInterface;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Impexta\Product\Domain\Enum\Guarantee;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProductCardModel implements ModelInterface
{
    /**
     * @Assert\Valid
     * @Assert\NotBlank(message="Musíte zvolit kategorii")
     */
    public CategoryInterface $category;

    /** @Assert\Length (max=255, maxMessage="Kód může mít maximálně 255 znaků") */
    public ?string $originalCode = null;

    /** @Assert\Length (max=255, maxMessage="Jméno může mít maximálně 255 znaků") */
    public string $name;
    public VatRate $vatRate;
    public Guarantee $guarantee;
    public ?string $description = null;
    public ?string $note = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, CarInterface> $cars
     */
    public Collection $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    /** @param ProductCardInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = new self();

        $model->category = $entity->getCategory();
        $model->originalCode = $entity->getOriginalCode();
        $model->name = $entity->getName();
        $model->vatRate = $entity->getVatRate();
        $model->guarantee = $entity->getGuarantee();
        $model->description = $entity->getDescription();
        $model->note = $entity->getNote();

        foreach ($entity->getCompatibleCars() as $car) {
            $model->cars->add($car->getCar());
        }

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
