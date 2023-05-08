<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Factory\InquiryFactory;
use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Impexta\Inquiry\Presentation\Form\Model\InquiryModel;
use Impexta\Inquiry\Presentation\Form\Type\InquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;
    private InquiryFactory $inquiryFactory;

    public function __construct(
        InquiryRepository $inquiryRepository,
        InquiryFactory $inquiryFactory
    ) {
        $this->inquiryRepository = $inquiryRepository;
        $this->inquiryFactory = $inquiryFactory;
    }

    /**
     * @Route("/poptavka/vytvorit", name="inquiry_crm_inquiry_create")
     */
    public function __invoke(Request $request): Response
    {
        $model = InquiryModel::createEmpty();
        $form = $this->createForm(InquiryType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inquiry = $this->inquiryFactory->create($model);
            $this->inquiryRepository->save($inquiry);
            $this->addFlash('success', 'Poptávka byla vytvořena.');

            return $this->redirectToRoute('inquiry_crm_inquiry_list');
        }

        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
