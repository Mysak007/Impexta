<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Impexta\Product\Domain\Entity\ProductInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ProductModel implements ModelInterface
{
    public ProductCardInterface $productCard;

    /**
     * @Assert\NotBlank(message="Kód musí být vyplněný")
     * @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $code;

    /**
     * @Assert\NotBlank(message="Jméno musí být vyplněno")
     * @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $name;

    /**
     * @Assert\NotBlank(message="Slug musí být vyplněný")
     * @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $slug;

    /**
     * @Assert\NotBlank(message="Výrobce musí být vyplněný")
     * @Assert\Length(max="255", maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $manufacturer;

    /**
     * @Assert\NotNull(message="Hodnota nesmí být prázdná")
     * @Assert\GreaterThan("0",message="Hodnota musí být větší než 0",)
     */
    public float $weight;
    public bool $needsExtraShipping;
    public ?int $leastInStock = null;
    public bool $showOnEshop;
    public bool $actionProduct;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, ProductImageModel>
     */
    public Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @param ProductInterface $entity
     */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $product = new self();
        $product->productCard = $entity->getProductCard();
        $product->code = $entity->getCode();
        $product->name = $entity->getName();
        $product->slug = $entity->getSlug();
        $product->manufacturer = $entity->getManufacturer();
        $product->weight = $entity->getWeight();
        $product->needsExtraShipping = $entity->doesNeedsExtraShipping();
        $product->leastInStock = $entity->getLeastInStock();
        $product->showOnEshop = $entity->isShowOnEshop();
        $product->actionProduct = $entity->isActionProduct();

        foreach ($entity->getImages() as $image) {
            $product->images[] = ProductImageModel::createFromEntity($image);
        }

        return $product;
    }

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }
}
