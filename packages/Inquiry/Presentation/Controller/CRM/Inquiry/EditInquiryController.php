<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Mapper\InquiryMapper;
use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Impexta\Inquiry\Infrastructure\Security\InquiryVoter;
use Impexta\Inquiry\Presentation\Form\Model\InquiryModel;
use Impexta\Inquiry\Presentation\Form\Type\InquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;
    private InquiryMapper $inquiryMapper;

    public function __construct(
        InquiryRepository $inquiryRepository,
        InquiryMapper $inquiryMapper
    ) {
        $this->inquiryRepository = $inquiryRepository;
        $this->inquiryMapper = $inquiryMapper;
    }

    /**
     * @Route("/poptavka/{id}/upravit", name="inquiry_crm_inquiry_edit")
     */
    public function __invoke(Request $request, Inquiry $inquiry): Response
    {
        $this->denyAccessUnlessGranted(InquiryVoter::CAN_UPDATE, $inquiry);
        $model = InquiryModel::createFromEntity($inquiry);
        $form = $this->createForm(InquiryType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->inquiryMapper->populateFromModel($model, $inquiry);
            $this->inquiryRepository->save($inquiry);

            $this->addFlash('success', 'Poptávka byla upravena.');

            return $this->redirectToRoute(
                'inquiry_crm_inquiry_detail',
                [
                    'id' => $inquiry->getId(),
                ]
            );
        }

        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_edit.html.twig',
            [
                'inquiry' => $inquiry,
                'form' => $form->createView(),
                'can_remove' => $this->isGranted(InquiryVoter::CAN_DELETE, $inquiry),
            ]
        );
    }
}
