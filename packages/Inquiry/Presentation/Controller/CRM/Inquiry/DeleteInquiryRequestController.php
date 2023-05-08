<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemOfferRepository;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemRequestRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteInquiryRequestController extends AbstractController
{
    private InquiryItemRequestRepository $inquiryItemRequestRepository;
    private InquiryItemOfferRepository $inquiryItemOfferRepository;

    public function __construct(
        InquiryItemRequestRepository $inquiryItemRequestRepository,
        InquiryItemOfferRepository $inquiryItemOfferRepository
    ) {
        $this->inquiryItemRequestRepository = $inquiryItemRequestRepository;
        $this->inquiryItemOfferRepository = $inquiryItemOfferRepository;
    }

    /**
     * @Route("/poptavka/dil/{id}/smazat", name="inquiry_crm_inquiry_request_delete")
     */
    public function __invoke(InquiryItemRequest $inquiryItemRequest): Response
    {
        $inquiry = $inquiryItemRequest->getInquiry();
        $this->denyAccessUnlessGranted(InquiryVoter::CAN_DELETE, $inquiry);

        foreach ($inquiryItemRequest->getItemOffers() as $itemOffer) {
            $inquiryItemRequest->removeItemOffer($itemOffer);
            $this->inquiryItemOfferRepository->removeAndSave($itemOffer);
        }

        $inquiry->removeItemRequest($inquiryItemRequest);
        $this->inquiryItemRequestRepository->removeAndSave($inquiryItemRequest);

        $this->addFlash('danger', 'Poptávaný díl byl smazán.');

        return $this->redirectToRoute(
            'inquiry_crm_inquiry_detail',
            [
                'id' => $inquiry->getId(),
            ]
        );
    }
}
