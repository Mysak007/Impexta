<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Product\Domain\Entity\SecondHandProduct;
use Impexta\Product\Infrastructure\Email\SecondHandProductAvailabilityEmailMessage;
use Impexta\Product\Presentation\Form\Model\Eshop\SecondHandProductContactFormModel;
use Impexta\Product\Presentation\Form\Type\Eshop\SecondHandProductContactFormType;
use Microshop\SymfonySurvivalKit\Mailer\AddressFactory;
use Microshop\SymfonySurvivalKit\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

final class SecondHandProductDetailController extends AbstractController
{
    /** @var Breadcrumbs<Breadcrumbs> */
    private Breadcrumbs $breadcrumbs;
    private MailerInterface $mailer;

    /**
     * @param Breadcrumbs<Breadcrumbs> $breadcrumbs
     */
    public function __construct(
        Breadcrumbs $breadcrumbs,
        MailerInterface $mailer
    ) {
        $this->breadcrumbs = $breadcrumbs;
        $this->mailer = $mailer;
    }

    /**
     * @Route("bazar/{slug}/{id}", name="product_eshop_second_hand_product_detail", requirements={"id"="\d+"})
     */
    public function __invoke(Request $request, SecondHandProduct $secondHandProduct): Response
    {
        $this->breadcrumbs->addItem('Naše nabídka');
        $this->breadcrumbs->addRouteItem('Bazar', 'product_eshop_second_hand_product_list');
        $this->breadcrumbs->addItem($secondHandProduct->getName());

        $model = new SecondHandProductContactFormModel();

        $form = $this->createForm(
            SecondHandProductContactFormType::class,
            $model
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailMessage = new SecondHandProductAvailabilityEmailMessage($model->text);

            $this->mailer->send($emailMessage, AddressFactory::createFromString($model->email));
            $this->addFlash('success', 'Dotaz na produkt byl úspěšně odeslán.');

            return $this->redirect($request->getUri());
        }

        return $this->render('@product/Eshop/SecondHandProduct/second_hand_product_detail.html.twig', [
            'product' => $secondHandProduct,
            'form' => $form->createView(),
        ]);
    }
}
