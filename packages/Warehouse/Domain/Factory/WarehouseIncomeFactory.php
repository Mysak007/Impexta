<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Factory;

use Impexta\Warehouse\Domain\Entity\WarehouseIncome;
use Impexta\Warehouse\Domain\Entity\WarehouseProduct;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseIncomeModel;

final class WarehouseIncomeFactory
{
    public function create(WarehouseIncomeModel $warehouseIncomeModel): WarehouseIncome
    {
        $warehouseIncome = new WarehouseIncome(
            $warehouseIncomeModel->documentId,
            $warehouseIncomeModel->warehouse,
            $warehouseIncomeModel->internalCode,
            $warehouseIncomeModel->date
        );

        $warehouseIncome->setNote($warehouseIncomeModel->note);

        foreach ($warehouseIncomeModel->warehouseProducts as $warehouseProductModel) {
            $warehouseProduct = new WarehouseProduct(
                $warehouseProductModel->product,
                $warehouseIncomeModel->warehouse,
                $warehouseProductModel->purchasePrice
            );
            $warehouseIncome->addWarehouseProduct($warehouseProduct);
        }

        return $warehouseIncome;
    }
}
