<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Model;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class AdminUserModel implements ModelInterface
{
    /** @Assert\NotBlank(groups={"registration"}) */
    public ?string $password = null;

    /** @Assert\NotBlank */
    public string $username;
    public bool $enabled;

    /** @Assert\NotBlank */
    public string $name;

    /** @Assert\NotBlank */
    public string $surname;

    /**
     * @param AdminUserInterface $adminUser
     */
    public static function createFromEntity(EntityInterface $adminUser): AdminUserModel
    {
        $model = new self();

        $model->username = $adminUser->getUsername();
        $model->enabled = $adminUser->isEnabled();
        $model->name = $adminUser->getName();
        $model->surname = $adminUser->getSurname();

        return $model;
    }

    public static function createEmpty(): AdminUserModel
    {
        return new self();
    }
}
