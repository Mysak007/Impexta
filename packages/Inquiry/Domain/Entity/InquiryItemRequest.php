<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class InquiryItemRequest implements InquiryItemRequestInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private InquiryInterface $inquiry;
    private ProductCardInterface $productCard;
    private ?ClientCarInterface $clientCar = null;
    private ?CarInterface $car = null;
    private int $quantity;
    private ?string $note = null;

    /** @var ArrayCollection<int,InquiryItemOfferInterface> $itemOffers */
    private Collection $itemOffers;

    public function __construct(
        InquiryInterface $inquiry,
        ProductCardInterface $productCard,
        int $quantity
    ) {
        $this->inquiry = $inquiry;
        $this->productCard = $productCard;
        $this->quantity = $quantity;
        $this->itemOffers = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInquiry(): InquiryInterface
    {
        return $this->inquiry;
    }

    public function getProductCard(): ProductCardInterface
    {
        return $this->productCard;
    }

    public function getClientCar(): ?ClientCarInterface
    {
        return $this->clientCar;
    }

    public function setClientCar(?ClientCarInterface $clientCar): void
    {
        $this->clientCar = $clientCar;
    }

    public function getCar(): ?CarInterface
    {
        return $this->car;
    }

    public function setCar(?CarInterface $car): void
    {
        $this->car = $car;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return ClientCarInterface|CarInterface|null
     */
    public function getItemRequestCar()
    {
        if ($this->clientCar) {
            return $this->clientCar;
        }

        if ($this->car) {
            return $this->car;
        }

        return null;
    }

    /**
     * @return ArrayCollection<int, InquiryItemOfferInterface>
     */
    public function getItemOffers(): Collection
    {
        return $this->itemOffers;
    }

    public function addItemOffer(InquiryItemOfferInterface $inquiryItemOffer): void
    {
        $this->getItemOffers()->add($inquiryItemOffer);
    }

    public function removeItemOffer(InquiryItemOfferInterface $inquiryItemOffer): void
    {
        $this->getItemOffers()->removeElement($inquiryItemOffer);
    }
}
