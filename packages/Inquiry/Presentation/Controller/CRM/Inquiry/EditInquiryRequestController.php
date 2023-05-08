<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\InquiryItemRequest;
use Impexta\Inquiry\Infrastructure\Mapper\InquiryItemRequestMapper;
use Impexta\Inquiry\Infrastructure\Repository\InquiryItemRequestRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Impexta\Inquiry\Presentation\Form\Model\InquiryItemRequestModel;
use Impexta\Inquiry\Presentation\Form\Type\InquiryItemRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditInquiryRequestController extends AbstractController
{
    private InquiryItemRequestMapper $inquiryItemRequestMapper;
    private InquiryItemRequestRepository $inquiryItemRequestRepository;

    public function __construct(
        InquiryItemRequestRepository $inquiryItemRequestRepository,
        InquiryItemRequestMapper $inquiryItemRequestMapper
    ) {
        $this->inquiryItemRequestMapper = $inquiryItemRequestMapper;
        $this->inquiryItemRequestRepository = $inquiryItemRequestRepository;
    }

    /**
     * @Route("/poptavka/dil/{id}/upravit", name="inquiry_crm_inquiry_request_edit")
     */
    public function __invoke(Request $request, InquiryItemRequest $inquiryItemRequest): Response
    {
        $this->denyAccessUnlessGranted(
            InquiryVoter::CAN_UPDATE,
            $inquiryItemRequest->getInquiry()
        );
        $model = InquiryItemRequestModel::createFromEntity($inquiryItemRequest);
        $form = $this->createForm(InquiryItemRequestType::class, $model, ['itemOffersDisabled' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->inquiryItemRequestMapper->populateFromModel($model, $inquiryItemRequest);
            $this->inquiryItemRequestRepository->save($inquiryItemRequest);

            $this->addFlash('success', 'Poptávka byla upravena.');

            return $this->redirectToRoute(
                'inquiry_crm_inquiry_detail',
                [
                    'id' => $inquiryItemRequest->getInquiry()->getId(),
                ]
            );
        }

        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_item_request_edit.html.twig',
            [
                'form' => $form->createView(),
                'inquiry' => $inquiryItemRequest->getInquiry(),
                'inquiryItemRequest' => $inquiryItemRequest,
            ]
        );
    }
}
