<?php

declare(strict_types=1);

namespace Impexta\ContactForm\Presentation\Controller\CRM;

use Impexta\ContactForm\Domain\Entity\ContactForm;
use Impexta\ContactForm\Infrastructure\Repository\ContactFormRepository;
use Impexta\ContactForm\Infrastructure\Security\ContactFormVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteContactFormController extends AbstractController
{
    private ContactFormRepository $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    /**
     * @Route("kontaktni-formular/{id}/smazat", name="contact_form_crm_contact_form_delete")
     */
    public function __invoke(ContactForm $contactForm): RedirectResponse
    {
        $this->denyAccessUnlessGranted(ContactFormVoter::DELETE, $contactForm);

        $this->contactFormRepository->removeAndSave($contactForm);
        $this->addFlash('success', 'Formulář byl odstraněn');

        return $this->redirectToRoute('contact_form_crm_contact_form_list');
    }
}
