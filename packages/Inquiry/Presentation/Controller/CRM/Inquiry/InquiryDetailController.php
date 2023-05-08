<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Infrastructure\Email\InquiryEmailMessage;
use Impexta\Inquiry\Infrastructure\Generator\InquiryPaperworkContainer;
use Impexta\Inquiry\Presentation\Form\Model\InquiryClientEmailModel;
use Impexta\Inquiry\Presentation\Form\Type\InquiryClientEmailType;
use League\Flysystem\FilesystemOperator;
use Microshop\SymfonySurvivalKit\Mailer\AddressFactory;
use Microshop\SymfonySurvivalKit\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InquiryDetailController extends AbstractController
{
    private FilesystemOperator $inquiryPdfStorage;
    private MailerInterface $mailer;
    private string $emailFrom;
    private InquiryPaperworkContainer $inquiryPaperworkContainer;

    public function __construct(
        FilesystemOperator $inquiryPdfStorage,
        MailerInterface $mailer,
        string $emailFrom,
        InquiryPaperworkContainer $inquiryPaperworkContainer
    ) {
        $this->inquiryPdfStorage = $inquiryPdfStorage;
        $this->mailer = $mailer;
        $this->emailFrom = $emailFrom;
        $this->inquiryPaperworkContainer = $inquiryPaperworkContainer;
    }

    /**
     * @Route("/poptavka/{id}", name="inquiry_crm_inquiry_detail")
     */
    public function __invoke(Inquiry $inquiry, Request $request): Response
    {
        $clientEmailModel = InquiryClientEmailModel::createFromEntity($inquiry);
        $clientEmailForm = $this->createForm(InquiryClientEmailType::class, $clientEmailModel);
        $clientEmailForm->handleRequest($request);

        if ($clientEmailForm->isSubmitted() && $clientEmailForm->isValid()) {
            $filename = $inquiry->getId() . '.pdf';

            if (!$this->inquiryPdfStorage->fileExists($filename)) {
                $this->inquiryPaperworkContainer->generate($inquiry);
            }

            $attachment = $this->inquiryPdfStorage->read($filename);
            $emailMessage = new InquiryEmailMessage($inquiry, $clientEmailModel->email, $attachment);
            $this->mailer->send($emailMessage, AddressFactory::createFromString($this->emailFrom));
            $this->addFlash('success', 'Poptávka byla odeslána na e-mail.');
        }

        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_detail.html.twig',
            [
                'inquiry' => $inquiry,
                'client_email_form' => $clientEmailForm->createView(),
            ]
        );
    }
}
