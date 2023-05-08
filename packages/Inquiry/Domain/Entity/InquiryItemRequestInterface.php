<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Client\Domain\Entity\ClientCarInterface;
use Impexta\Product\Domain\Entity\ProductCardInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface InquiryItemRequestInterface extends EntityInterface
{
    public function getId(): int;

    public function getInquiry(): InquiryInterface;

    public function getProductCard(): ProductCardInterface;

    public function getClientCar(): ?ClientCarInterface;

    public function setClientCar(?ClientCarInterface $clientCar): void;

    public function getCar(): ?CarInterface;

    public function setCar(?CarInterface $car): void;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /**
     * @return ClientCarInterface|CarInterface|null
     */
    public function getItemRequestCar();

    /**
     * @return ArrayCollection<int, InquiryItemOfferInterface>
     */
    public function getItemOffers(): Collection;

    public function addItemOffer(InquiryItemOfferInterface $inquiryItemOffer): void;

    public function removeItemOffer(InquiryItemOfferInterface $inquiryItemOffer): void;
}
