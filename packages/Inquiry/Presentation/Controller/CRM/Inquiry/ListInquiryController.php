<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Infrastructure\Repository\InquiryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListInquiryController extends AbstractController
{
    private InquiryRepository $inquiryRepository;

    public function __construct(
        InquiryRepository $inquiryRepository
    ) {
        $this->inquiryRepository = $inquiryRepository;
    }

    /**
     * @Route("/poptavky", name="inquiry_crm_inquiry_list")
     */
    public function __invoke(): Response
    {
        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_list.html.twig',
            [
                'inquiries' => $this->inquiryRepository->findAll(),
            ]
        );
    }
}
