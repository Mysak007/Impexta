<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class InquiryItemRequestModel implements ModelInterface
{
    /** @Assert\Valid */
    public InquiryInterface $inquiry;

    /** @Assert\Valid */
    public ProductCardInterface $productCard;

    /** @Assert\Valid */
    /** @var string|int|ClientCarInterface|null $clientCar */
    public $clientCar = null;

    /** @Assert\Valid */
    public ?CarInterface $car = null;

    /**
     * @Assert\NotBlank(message="Hodnota nesmí být prázdná")
     * @Assert\GreaterThan(value="-1",message="Množství musí být kladné číslo")
     */
    public int $quantity;

    /** @Assert\Length(max=255,maxMessage="Délka nesmí být větší než 255 znaků") */
    public ?string $note = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, InquiryItemOfferModel>
     */
    public Collection $itemOffers;

    public function __construct()
    {
        $this->itemOffers = new ArrayCollection();
    }

    /** @param InquiryItemRequestInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $model = self::createEmpty();
        $model->inquiry = $entity->getInquiry();
        $model->productCard = $entity->getProductCard();

        if ($entity->getClientCar()) {
            $model->clientCar = $entity->getClientCar();
        }

        $model->car = $entity->getCar();
        $model->quantity = $entity->getQuantity();
        $model->note = $entity->getNote();

        $itemOffers = [];

        foreach ($entity->getItemOffers() as $itemOffer) {
            $itemOffers[] = InquiryItemOfferModel::createFromEntity($itemOffer);
        }

        if ($itemOffers) {
            $model->itemOffers = new ArrayCollection($itemOffers);
        }

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
