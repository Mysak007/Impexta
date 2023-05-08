<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface WarehouseIncomeInterface extends EntityInterface
{
    public function getId(): int;

    public function getDocumentId(): string;

    public function setDocumentId(string $documentId): void;

    public function getWarehouse(): Warehouse;

    public function setWarehouse(Warehouse $warehouse): void;

    public function getInternalCode(): string;

    public function setInternalCode(string $internalCode): void;

    public function getDate(): DateTimeImmutable;

    public function setDate(DateTimeImmutable $date): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /**
     * @return ArrayCollection<int, WarehouseProductInterface>
     */
    public function getWarehouseProducts(): ArrayCollection;

    public function addWarehouseProduct(WarehouseProductInterface $product): void;

    public function removeWarehouseProduct(WarehouseProductInterface $product): void;

    /**
     * @param ArrayCollection<int, WarehouseProductInterface> $products
     */
    public function setWarehouseProducts(ArrayCollection $products): void;
}
