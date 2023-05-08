<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Form\Model;

use Impexta\Client\Domain\Entity\ClientPersonalDetailsInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientPersonalDetailsModel implements ModelInterface
{
    /**
     * @Assert\Length(min=3, max=255, minMessage="Jméno musí mít minimálně 3 znaky")
     * @Assert\Expression("this.isCompanyNameSet() == true", message="Jméno a příjmení nebo název firmy jsou povinné")
     */
    public ?string $firstName = null;

    /**
     * @Assert\Length(min=3, max=255, minMessage="Jméno musí mít minimálně 3 znaky")
     * @Assert\Expression("this.isCompanyNameSet() == true", message="Jméno a příjmení nebo název firmy jsou povinné")
     */
    public ?string $lastName = null;

    /**
     * @Assert\Length(min=3, max=255, minMessage="Jméno musí mít minimálně 3 znaky")
     * @Assert\Expression("this.isCompanyNameSet() == true", message="Jméno a příjmení nebo název firmy jsou povinné")
     */
    public ?string $companyName = null;

    /**
     * @Assert\Length(min="8", max="8", exactMessage="IČ musí mít 8 znaků")
     * @Assert\Positive(message="IČ musí být číslo")
     */
    public ?string $taxId = null;

    /**
     * @Assert\Length(
     *     min="8",
     *     max="10",
     *     minMessage="DIČ musí mít alespoň 8 znaků",
     *     maxMessage="DIČ může mít maximálně 10 znaků"
     * )
     */
    public ?string $vatId = null;
    public ?string $vatIdSk = null;

    public static function createEmpty(): ModelInterface
    {
        return new self();
    }

    public function isCompanyNameSet(): bool
    {
        if ($this->companyName) {
            return true;
        }

        return $this->firstName && $this->lastName;
    }

    /**
     * @param ClientPersonalDetailsInterface $clientPersonalDetails
     */
    public static function createFromEntity(EntityInterface $clientPersonalDetails): self
    {
        $model = new self();

        $model->taxId = $clientPersonalDetails->getTaxId();
        $model->vatId = $clientPersonalDetails->getVatId();
        $model->vatIdSk = $clientPersonalDetails->getVatIdSk();
        $model->firstName = $clientPersonalDetails->getFirstName();
        $model->lastName = $clientPersonalDetails->getLastName();
        $model->companyName = $clientPersonalDetails->getCompanyName();

        return $model;
    }
}
