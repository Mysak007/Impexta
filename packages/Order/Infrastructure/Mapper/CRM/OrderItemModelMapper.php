<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Mapper\CRM;

use Impexta\Order\Domain\Model\OrderItemModel;
use Impexta\Order\Presentation\Form\CRM\Model\OrderItemModel as CRMModel;

final class OrderItemModelMapper
{
    public function mapFromCrmItemModel(OrderItemModel $mainModel, CRMModel $crmModel): void
    {
        $mainModel->product = $crmModel->product;
        $mainModel->quantity = $crmModel->quantity;
        $mainModel->unitPrice = $crmModel->unitPrice;
    }
}
