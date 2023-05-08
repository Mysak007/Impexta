<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Form\Model;

use Impexta\Inquiry\Domain\Entity\InquiryItemOfferInterface;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class InquiryItemOfferOrderModel
{
    public bool $isSelected;

    /** @Assert\Valid */
    public InquiryItemRequestInterface $inquiryItemRequest;
    public ?InquiryItemOfferInterface $inquiryItemOffer = null;

    public static function createEmpty(): self
    {
        return new self();
    }
}
