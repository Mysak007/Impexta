<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Order\Domain\Enum\PaymentMethod;
use Impexta\Shipping\Domain\Enum\ShippingMethod;
use Symfony\Component\Validator\Constraints as Assert;

final class InquiryCreateOrderModel
{
    public PaymentMethod $payment;
    public ShippingMethod $shipment;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, InquiryItemOfferOrderModel>
     */
    public Collection $itemOffers;

    public function __construct()
    {
        $this->itemOffers = new ArrayCollection();
    }

    public static function createFromEntity(Inquiry $inquiry): self
    {
        $model = self::createEmpty();
        $itemOffers = [];

        foreach ($inquiry->getItemRequests() as $itemRequest) {
            $inquiryItemOffer = InquiryItemOfferOrderModel::createEmpty();
            $inquiryItemOffer->inquiryItemRequest = $itemRequest;
            $itemOffers[] = $inquiryItemOffer;
        }

        $model->itemOffers = new ArrayCollection($itemOffers);

        return $model;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
