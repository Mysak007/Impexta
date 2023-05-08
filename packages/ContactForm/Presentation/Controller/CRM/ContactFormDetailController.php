<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Presentation\Controller\CRM;

use Impexta\ContactForm\Domain\Entity\ContactForm;
use Impexta\ContactForm\Infrastructure\Security\ContactFormVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ContactFormDetailController extends AbstractController
{
    /** @Route("kontaktni-formular/{id}", name="contact_form_crm_contact_form_detail") */
    public function __invoke(ContactForm $contactForm): Response
    {
        $this->denyAccessUnlessGranted(ContactFormVoter::VIEW, ContactForm::class);

        return $this->render('@contactform/CRM/contact_form_detail.html.twig', [
            'form' => $contactForm,
        ]);
    }
}
