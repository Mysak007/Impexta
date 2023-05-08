<?php

declare(strict_types=1);

namespace Impexta\Order\Infrastructure\Mapper\CRM;

use Impexta\Order\Domain\Enum\OrderOrigin;
use Impexta\Order\Domain\Model\OrderItemModel;
use Impexta\Order\Domain\Model\OrderModel;
use Impexta\Order\Presentation\Form\CRM\Model\OrderModel as CRMModel;

final class OrderModelMapper
{
    private OrderItemModelMapper $orderItemModelMapper;

    public function __construct(OrderItemModelMapper $orderItemModelMapper)
    {
        $this->orderItemModelMapper = $orderItemModelMapper;
    }

    public function mapFromCrmModel(OrderModel $mainModel, CRMModel $crmModel): void
    {
        $mainModel->client = $crmModel->client;
        $mainModel->shippingMethod = $crmModel->shippingMethod;
        $mainModel->paymentMethod = $crmModel->paymentMethod;
        $mainModel->origin = OrderOrigin::get(OrderOrigin::CRM);
        $mainModel->currency = $crmModel->currency;

        $clientCar = $crmModel->clientCar;
        $extraSale = $crmModel->extraSale;
        $orderItems = $crmModel->items;

        if ($crmModel->selectedShippingAddress) {
            $shippingAddress = $crmModel->selectedShippingAddress;
        }

        if ($crmModel->filledInShippingAddress) {
            $shippingAddress = $crmModel->selectedShippingAddress;
        }

        if (isset($shippingAddress)) {
            $mainModel->shippingAddress = $shippingAddress;
        }

        if ($clientCar) {
            $mainModel->clientCar = $clientCar;
        }

        if ($extraSale) {
            $mainModel->extraSale = $extraSale;
        }

        if (count($orderItems) <= 0) {
            return;
        }

        foreach ($orderItems as $orderItem) {
            $mainOrderItemModel = OrderItemModel::createEmpty();
            $this->orderItemModelMapper->mapFromCrmItemModel($mainOrderItemModel, $orderItem);
            $mainModel->items->add($mainOrderItemModel);
        }
    }
}
