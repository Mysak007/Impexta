<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Presentation\Form\Model;

use Impexta\ContactForm\Domain\Entity\ContactFormInterface;
use Microshop\SymfonySurvivalKit\Contracts\EntityInterface;
use Microshop\SymfonySurvivalKit\Contracts\ModelInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ContactFormModel implements ModelInterface
{
    /** @Assert\NotBlank(message="Musíte vyplnit jméno") */
    public string $name;

    /**
     * @Assert\NotBlank(message="Musíte vyplnit email")
     * @Assert\Email(message="Email není platný")
     * @Assert\Length(max=255, maxMessage="Email může mít maximálně 255 znaků")
     */
    public string $email;

    /** @Assert\NotBlank(message="Musíte vyplnit zprávu") */
    public string $message;

    /** @Assert\Length(max=17,maxMessage="Maximální délka je 17 znaků") */
    public ?string $vin = null;

    /**
     * @Assert\Regex(
     *     "/^((\+420)|(\+421))(\s?\d{3}){3}$/",
     *     message="Prosím zadejte telefonní číslo v mezinárodním formátu, např. +420 123 456 789")
     */
    public ?string $phone = null;

    /**
     * @param ContactFormInterface $contactForm
     */
    public static function createFromEntity(EntityInterface $contactForm): self
    {
        $contactFormModel = self::createEmpty();
        $contactFormModel->name = $contactForm->getName();
        $contactFormModel->email = $contactForm->getEmail();
        $contactFormModel->message = $contactForm->getMessage();
        $contactFormModel->vin = $contactForm->getVin();
        $contactFormModel->phone = $contactForm->getPhone();

        return $contactFormModel;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
