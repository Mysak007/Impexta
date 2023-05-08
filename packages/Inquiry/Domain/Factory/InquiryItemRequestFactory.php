<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Factory;

use Impexta\Inquiry\Domain\Entity\InquiryInterface;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemRequestModel;

final class InquiryItemRequestFactory
{
    public static function create(InquiryItemRequestModel $model, InquiryInterface $inquiry): InquiryItemRequest
    {
        return new InquiryItemRequest($inquiry, $model->productCard, $model->quantity);
    }
}
