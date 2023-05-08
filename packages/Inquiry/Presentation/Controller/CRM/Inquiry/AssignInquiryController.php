<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Impexta\User\Domain\Entity\AdminUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class AssignInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;

    public function __construct(InquiryRepository $inquiryRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
    }

    /**
     * @Route("/poptavka/{id}/priradit", name="inquiry_crm_inquiry_assign")
     * @param UserInterface&AdminUserInterface $user
     */
    public function __invoke(Inquiry $inquiry, UserInterface $user): Response
    {
        $this->denyAccessUnlessGranted(InquiryVoter::CAN_ASSIGN, $inquiry);
        $inquiry->setAssignee($user);
        $this->inquiryRepository->save($inquiry);

        return $this->redirectToRoute('inquiry_crm_inquiry_detail', [
            'id' => $inquiry->getId(),
        ]);
    }
}
