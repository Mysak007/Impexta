<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Domain\Factory;

use Impexta\ContactForm\Domain\Entity\ContactForm;
use Impexta\ContactForm\Presentation\Form\Model\ContactFormModel;

final class ContactFormFactory
{
    public function create(ContactFormModel $contactFormModel): ContactForm
    {
        $contactForm = new ContactForm($contactFormModel->name, $contactFormModel->email, $contactFormModel->message);
        $contactForm->setVin($contactFormModel->vin);
        $contactForm->setPhone($contactFormModel->phone);

        return $contactForm;
    }
}
