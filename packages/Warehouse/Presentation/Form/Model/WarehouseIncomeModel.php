<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Form\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Warehouse\Domain\Entity\WarehouseIncomeInterface;
use Impexta\Warehouse\Domain\Enum\Warehouse;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class WarehouseIncomeModel implements ModelInterface
{
    /**
     * @Assert\NotBlank(message="Číslo dokumentu nesmí být prázdné")
     * @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $documentId;

    /** @Assert\NotBlank(message="Sklad nesmí být prázdný") */
    public Warehouse $warehouse;

    /**
     * @Assert\NotBlank(message="Kód nesmí být prázdný")
     * @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $internalCode;

    /**
     * @Assert\NotBlank(message="Datum musí být vyplněno")
     * @Assert\Valid
     */
    public DateTimeImmutable $date;
    public ?string $note = null;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, WarehouseProductModel>
     */
    public Collection $warehouseProducts;

    public function __construct()
    {
        $this->warehouseProducts = new ArrayCollection();
    }

    /** @param WarehouseIncomeInterface $entity */
    public static function createFromEntity(EntityInterface $entity): ModelInterface
    {
        $warehouseIncomeModel = self::createEmpty();
        $warehouseIncomeModel->documentId = $entity->getDocumentId();
        $warehouseIncomeModel->warehouse = $entity->getWarehouse();
        $warehouseIncomeModel->internalCode = $entity->getInternalCode();
        $warehouseIncomeModel->date = $entity->getDate();
        $warehouseIncomeModel->note = $entity->getNote();
        $warehouseIncomeModel->warehouseProducts = new ArrayCollection();

        foreach ($entity->getWarehouseProducts() as $warehouseProduct) {
            $warehouseIncomeModel->warehouseProducts[] = WarehouseProductModel::createFromEntity($warehouseProduct);
        }

        return $warehouseIncomeModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
