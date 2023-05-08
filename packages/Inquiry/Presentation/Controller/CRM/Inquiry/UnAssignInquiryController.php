<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UnAssignInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;

    public function __construct(InquiryRepository $inquiryRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
    }

    /**
     * @Route("/poptavka/{id}/zrusit_prirazeni", name="inquiry_crm_inquiry_unassign")
     */
    public function __invoke(Inquiry $inquiry): Response
    {
        $this->denyAccessUnlessGranted(InquiryVoter::CAN_UNASSIGN, $inquiry);
        $inquiry->setAssignee(null);
        $this->inquiryRepository->save($inquiry);

        return $this->redirectToRoute('inquiry_crm_inquiry_detail', [
            'id' => $inquiry->getId(),
        ]);
    }
}
