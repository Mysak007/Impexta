<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Form\Model;

use Impexta\Store\Domain\Entity\StoreContactInformationInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class StoreContactInformationModel implements ModelInterface
{
    /** @Assert\Length(max = 255,maxMessage="Maximální povolená délka je 255 znaků") */
    public ?string $email = null;

    /**
     * Format with min chars: "730695655" (9)
     * Format with max chars: "00420 730 695 655" (17)
     *
     * @Assert\Length(min="9", max="17",
     *      minMessage="Telefonní číslo není ve správném formátu (123 456 789)",
     *      maxMessage="Telefonní číslo není ve správném formátu (123 456 789)")
     */
    public ?string $phone = null;

    /**
     * Format with min chars: "730695655" (9)
     * Format with max chars: "00420 730 695 655" (17)
     *
     * @Assert\Length(min="9", max="17",
     *      minMessage="Telefonní číslo není ve správném formátu (123 456 789)",
     *      maxMessage="Telefonní číslo není ve správném formátu (123 456 789)")
     */
    public ?string $landline = null;

    /** @Assert\Length(min="6",max = "32",
     *     minMessage="Minimálné délka uživatelského jména je 6 znaků",
     *      maxMessage="Maximální délka uživatelského jména je 32 znaků")
     */
    public ?string $skype = null;

    /** @param StoreContactInformationInterface $entity */
    public static function createFromEntity(EntityInterface $entity): self
    {
        $contactInformation = self::createEmpty();
        $contactInformation->email = $entity->getEmail();
        $contactInformation->phone = $entity->getPhone();
        $contactInformation->landline = $entity->getLandline();
        $contactInformation->skype = $entity->getSkype();

        return $contactInformation;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
