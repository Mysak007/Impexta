<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Presentation\Controller\CRM;

use Impexta\ContactForm\Infrastructure\Repository\ContactFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListContactFormController extends AbstractController
{
    private ContactFormRepository $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    /** @Route("kontaktni-formulare", name="contact_form_crm_contact_form_list") */
    public function __invoke(): Response
    {
        $forms = $this->contactFormRepository->findAll();

        return $this->render(
            '@contactform/CRM/contact_form_list.html.twig',
            [
            'forms' => $forms,
            ]
        );
    }
}
