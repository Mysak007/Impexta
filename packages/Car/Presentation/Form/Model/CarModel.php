<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Form\Model;

use Impexta\Car\Domain\Entity\CarInterface;
use Impexta\Car\Domain\Enum\CarCategory;
use Impexta\Car\Infrastructure\Validator as CarModelAssert;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CarModel implements ModelInterface
{
    /** @see https://regex101.com/r/rWIx7V/1 */
    public const ENGINE_CAPACITY_MULTILINE_REGEX = '/^\d{1}([\.,]\d{1})?$/';

    /** @see https://regex101.com/r/ar7LTd/1 */
    public const YEAR_OF_MANUFACTURE_MULTILINE_REGEX = '/^(19[0-9]{2}|2[0-9]{3})$/';

    /** @see https://regex101.com/r/eaAmgB/1 */
    public const ESCAPE_NEW_LINE_REGEX = "/\r\n|\r|\n/";

    /**
     * @Assert\NotBlank(message="Název nesmí být prázdný")
     * @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $manufacturer;

    /** @Assert\Valid */
    public CarCategory $category;

    /**
     * @Assert\NotBlank(message="Model nesmí být prázdný")
     * @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $model;

    /**
     * @Assert\NotNull
     * @CarModelAssert\IsValidMultilineYearOfManufacture
     */
    public string $yearOfManufacture;

    /**
     * @Assert\NotNull
     * @CarModelAssert\IsValidMultilineEngineCapacity
     */
    public string $engineCapacity;
    public ?string $note = null;
    public bool $hideOnEshop = false;

    /**
     * @param CarInterface $car
     */
    public static function createFromEntity(EntityInterface $car): self
    {
        $carModel = self::createEmpty();
        $carModel->manufacturer = $car->getManufacturer()->getName();
        $carModel->category = $car->getCarCategory();
        $carModel->model = $car->getModel();
        $carModel->yearOfManufacture = (string)$car->getYearOfManufacture();
        $carModel->engineCapacity = (string)$car->getEngineCapacity();
        $carModel->note = $car->getNote();
        $carModel->hideOnEshop = $car->isHideOnEshop();

        return $carModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
