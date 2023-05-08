<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Entity\SecondHandProductInterface;
use Impexta\Product\Domain\Enum\VatRate;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Money\Money;
use Symfony\Component\Validator\Constraints as Assert;

final class SecondHandProductModel implements ModelInterface
{
    /**
     * @Assert\NotBlank(message="Jméno musí být vyplněno")
     * @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $name;

    /** @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků") */
    public ?string $perex = null;
    public ?string $description = null;

    /** @Assert\NotBlank(message="Cena musí být vyplněna") */
    public Money $price;
    public VatRate $vatRate;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, SecondHandProductImageModel>
     */
    public Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @param SecondHandProductInterface $entity
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $secondHandProduct = new self();
        $secondHandProduct->name = $entity->getName();
        $secondHandProduct->perex = $entity->getPerex();
        $secondHandProduct->description = $entity->getDescription();
        $secondHandProduct->price = $entity->getPrice();
        $secondHandProduct->vatRate = $entity->getVatRate();

        foreach ($entity->getSecondHandProductImages() as $image) {
            $secondHandProduct->images[] = SecondHandProductImageModel::createFromEntity($image);
        }

        return $secondHandProduct;
    }

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
