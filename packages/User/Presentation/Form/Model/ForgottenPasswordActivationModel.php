<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Model;

use Impexta\User\Domain\Entity\ShopUserInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ForgottenPasswordActivationModel implements ModelInterface
{
    /** @Assert\NotBlank */
    public string $email;

    /**
     * @param ShopUserInterface $shopUser
     */
    public static function createFromEntity(EntityInterface $shopUser): ForgottenPasswordActivationModel
    {
        $model = new self();

        $model->email = $shopUser->getEmail();

        return $model;
    }

    public static function createEmpty(): ForgottenPasswordActivationModel
    {
        return new self();
    }
}
