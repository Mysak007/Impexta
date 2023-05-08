<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Domain\Factory;

use Impexta\Inquiry\Domain\Entity\InquiryItemOffer;
use Impexta\Inquiry\Domain\Entity\InquiryItemRequestInterface;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemOfferModel;

final class InquiryItemOfferFactory
{
    public static function create(
        InquiryItemOfferModel $model,
        InquiryItemRequestInterface $inquiryItemRequest
    ): InquiryItemOffer {
        $itemOffer = new InquiryItemOffer($inquiryItemRequest, $model->product, $model->price);
        $itemOffer->setWarehouseProduct($model->warehouseProduct);

        return $itemOffer;
    }
}
