<?php

declare(strict_types=1);

namespace Impexta\Car\Presentation\Form\Model;

use Impexta\Car\Domain\Entity\CarManufacturerInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class CarManufacturerModel implements ModelInterface
{
    /**
     * @Assert\NotBlank(message="Název nesmí být prázdný")
     * @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků")
     */
    public string $name;
    public bool $showOnEshop = false;

    /**
     * @param CarManufacturerInterface $carManufacturer
     */
    public static function createFromEntity(EntityInterface $carManufacturer): self
    {
        $carManufacturerModel = self::createEmpty();
        $carManufacturerModel->name = $carManufacturer->getName();
        $carManufacturerModel->showOnEshop = $carManufacturer->isShowOnEshop();

        return $carManufacturerModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
