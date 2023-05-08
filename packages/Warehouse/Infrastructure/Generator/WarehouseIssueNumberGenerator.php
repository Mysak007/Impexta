<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Infrastructure\Generator;

use Impexta\Warehouse\Infrastructure\Repository\WarehouseIssueRepository;

final class WarehouseIssueNumberGenerator
{
    private WarehouseIssueRepository $warehouseIssueRepository;

    public function __construct(WarehouseIssueRepository $warehouseIssueRepository)
    {
        $this->warehouseIssueRepository = $warehouseIssueRepository;
    }

    public function generateIssueNumber(): string
    {
        $lastIssue = $this->warehouseIssueRepository->findOneBy([], ['id' => 'DESC']);
        $currentYear = date("Y");

        if ($lastIssue) {
            $number = $lastIssue->getId() + 1;

            return $currentYear . $this->addDigits($number, 5);
        }

        return (string)$currentYear . $this->addDigits(1, 5);
    }

    private function addDigits(int $number, int $digits): string
    {
        $strNumber = $number;

        for ($loop = 1; $loop < $digits; $loop++) {
            if ($number >= 10 ** $loop) {
                continue;
            }

            $strNumber = '0' . $strNumber;
        }

        return (string)$strNumber;
    }
}
