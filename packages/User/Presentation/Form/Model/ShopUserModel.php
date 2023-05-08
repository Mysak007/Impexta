<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientInterface;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Impexta\User\Infrastructure\Validator as EmailAssert;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ShopUserModel implements ModelInterface
{
    /** @Assert\NotBlank(groups={"registration"}) */
    public ShopUserPasswordModel $password;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @EmailAssert\ShopUserEmailExists
     */
    public string $email;
    public bool $enabled = false;
    public ?ClientInterface $client = null;

    public function __construct()
    {
        $this->password = ShopUserPasswordModel::createEmpty();
    }

    /**
     * @param ShopUserInterface $shopUser
     */
    public static function createFromEntity(EntityInterface $shopUser): ShopUserModel
    {
        $model = new self();

        $model->email = $shopUser->getEmail();
        $model->password = ShopUserPasswordModel::createEmpty();
        $model->enabled = $shopUser->isEnabled();
        $model->client = $shopUser->getClient();

        return $model;
    }

    public static function createEmpty(): ShopUserModel
    {
        return new self();
    }
}
