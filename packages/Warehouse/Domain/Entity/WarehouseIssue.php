<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class WarehouseIssue implements WarehouseIssueInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $documentId;
    private Warehouse $warehouse;
    private AdminUserInterface $createdBy;
    private string $internalCode;
    private DateTimeImmutable $date;
    private ?string $note = null;

    /** @var ArrayCollection<int,WarehouseProductInterface> $warehouseProducts*/
    private Collection $warehouseProducts;

    public function __construct(
        string $documentId,
        Warehouse $warehouse,
        AdminUserInterface $createdBy,
        string $internalCode,
        DateTimeImmutable $date
    ) {
        $this->warehouse = $warehouse;
        $this->createdBy = $createdBy;
        $this->documentId = $documentId;
        $this->internalCode = $internalCode;
        $this->date = $date;
        $this->warehouseProducts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function setDocumentId(string $documentId): void
    {
        $this->documentId = $documentId;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }

    public function getCreatedBy(): AdminUserInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(AdminUserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getInternalCode(): string
    {
        return $this->internalCode;
    }

    public function setInternalCode(string $internalCode): void
    {
        $this->internalCode = $internalCode;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /**
     * @return ArrayCollection<int, WarehouseProductInterface>
     */
    public function getWarehouseProducts(): Collection
    {
        return $this->warehouseProducts;
    }

    public function addWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->add($warehouseProduct);
    }

    public function removeWarehouseProduct(WarehouseProductInterface $warehouseProduct): void
    {
        $this->warehouseProducts->removeElement($warehouseProduct);
    }

    /**
     * @param ArrayCollection<int, WarehouseProductInterface> $warehouseProducts
     */
    public function setWarehouseProducts(ArrayCollection $warehouseProducts): void
    {
        $this->warehouseProducts = $warehouseProducts;
    }
}
