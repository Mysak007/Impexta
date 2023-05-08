<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientContactDetailsInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientContactDetailsModel implements ModelInterface
{
    /**
     * @Assert\NotBlank(message="Musíte vyplnit email")
     * @Assert\Email(message="Email není platný")
     * @Assert\Length(max=255, maxMessage="Email může mít maximálně 255 znaků")
     */
    public string $email;

    /**
     * @Assert\Regex(
     *     "/^((\+420)|(\+421))(\s?\d{3}){3}$/",
     *     message="Prosím zadejte telefonní číslo v mezinárodním formátu, např. +420 123 456 789")
     * @Assert\NotBlank(message="Telefonní číslo nesmí být prázdné")
     */

    public string $phone;

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }

    /**
     * @param ClientContactDetailsInterface $clientContactDetails
     */
    public static function createFromEntity(EntityInterface $clientContactDetails): self
    {
        $model = new self();

        $model->email = $clientContactDetails->getEMail();
        $model->phone = $clientContactDetails->getPhone();

        return $model;
    }
}
