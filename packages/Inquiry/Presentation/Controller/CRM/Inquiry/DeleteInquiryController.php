<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;

    public function __construct(
        InquiryRepository $inquiryRepository
    ) {
        $this->inquiryRepository = $inquiryRepository;
    }

    /**
     * @Route("/poptavka/{id}/smazat", name="inquiry_crm_inquiry_delete")
     */
    public function __invoke(Inquiry $inquiry): Response
    {
        $this->denyAccessUnlessGranted(InquiryVoter::CAN_DELETE, $inquiry);
        $this->inquiryRepository->removeAndSave($inquiry);

        $this->addFlash('danger', 'Poptávka byla smazána.');

        return $this->redirectToRoute(
            'inquiry_crm_inquiry_list'
        );
    }
}
