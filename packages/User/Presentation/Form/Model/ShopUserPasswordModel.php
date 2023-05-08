<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Model;

use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ShopUserPasswordModel implements ModelInterface
{
    /** @Assert\NotBlank(groups={"registration"}) */
    public ?string $password = null;

    public static function createEmpty(): ShopUserPasswordModel
    {
        return new self();
    }

    /**
     * @param ShopUserInterface $shopUser
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public static function createFromEntity(EntityInterface $shopUser): ShopUserPasswordModel
    {
        return new self();
    }
}
