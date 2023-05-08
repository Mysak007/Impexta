<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Impexta\Store\Domain\Entity\StoreInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreModel implements ModelInterface
{
    /**
     * @Assert\NotBlank(message="Jméno nesmí být prázdné")
     * @Assert\Length(max=255, maxMessage="Maximální délka je 255 znaků")
     */
    public string $name;

    /** @Assert\Valid */
    public StoreAddressModel $address;

    /** @Assert\Valid */
    public StoreContactInformationModel $contactInformation;

    /**
     * @Assert\Valid
     * @var ArrayCollection<int, StoreOpeningHoursModel>
     */
    public Collection $openingHours;

    public function __construct()
    {
        $this->openingHours = new ArrayCollection();
    }

    /** @param StoreInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $storeModel = self::createEmpty();
        $storeModel->name = $entity->getName();
        $storeModel->contactInformation = StoreContactInformationModel::createFromEntity(
            $entity->getContactInformation()
        );
        $storeModel->address = StoreAddressModel::createFromEntity($entity->getAddress());

        $openingHoursModels = [];

        foreach ($entity->getOpeningHours() as $openingHour) {
            $openingHoursModels[] = StoreOpeningHoursModel::createFromEntity($openingHour);
        }

        $storeModel->openingHours = new ArrayCollection($openingHoursModels);

        return $storeModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
