<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Doctrine\Entity\TimestampableEntityTrait;

class WarehouseIncome implements WarehouseIncomeInterface
{
    use TimestampableEntityTrait;

    private int $id;
    private string $documentId;
    private Warehouse $warehouse;
    private string $internalCode;
    private DateTimeImmutable $date;
    private ?string $note = null;

    /** @var ArrayCollection<int,WarehouseProductInterface> $products*/
    private Collection $products;

    public function __construct(
        string $documentId,
        Warehouse $warehouse,
        string $internalCode,
        DateTimeImmutable $date
    ) {
        $this->warehouse = $warehouse;
        $this->documentId = $documentId;
        $this->internalCode = $internalCode;
        $this->date = $date;
        $this->products = new ArrayCollection();
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
    public function getWarehouseProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function addWarehouseProduct(WarehouseProductInterface $product): void
    {
        $this->products->add($product);
    }

    public function removeWarehouseProduct(WarehouseProductInterface $product): void
    {
        $this->products->removeElement($product);
    }

    /**
     * @param ArrayCollection<int, WarehouseProductInterface> $products
     */
    public function setWarehouseProducts(ArrayCollection $products): void
    {
        $this->products = $products;
    }
}
