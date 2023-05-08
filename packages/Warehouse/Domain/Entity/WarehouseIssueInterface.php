<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;

interface WarehouseIssueInterface extends EntityInterface
{
    public function getId(): int;

    public function getDocumentId(): string;

    public function setDocumentId(string $documentId): void;

    public function getWarehouse(): Warehouse;

    public function setWarehouse(Warehouse $warehouse): void;

    public function getCreatedBy(): AdminUserInterface;

    public function setCreatedBy(AdminUserInterface $createdBy): void;

    public function getInternalCode(): string;

    public function setInternalCode(string $internalCode): void;

    public function getDate(): DateTimeImmutable;

    public function setDate(DateTimeImmutable $date): void;

    public function getNote(): ?string;

    public function setNote(?string $note): void;

    /**
     * @return ArrayCollection<int, WarehouseProductInterface>
     */
    public function getWarehouseProducts(): Collection;

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void;

    /**
     * @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts
     */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void;
}
