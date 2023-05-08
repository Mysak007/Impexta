<?php

declare(strict_types=1);

namespace Impexta\Product\Presentation\Controller\Eshop;

use Impexta\Product\Infrastructure\Email\SecondHandProductAvailabilityEmailMessage;
use Impexta\Product\Infrastructure\Repository\SecondHandProductRepository;
use Impexta\Product\Presentation\Form\Model\Eshop\SecondHandProductContactFormModel;
use Impexta\Product\Presentation\Form\Type\Eshop\SecondHandProductContactFormType;
use Knp\Component\Pager\PaginatorInterface;
use Microshop\SymfonySurvivalKit\Mailer\AddressFactory;
use Microshop\SymfonySurvivalKit\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

final class SecondHandProductListController extends AbstractController
{
    private SecondHandProductRepository $secondHandProductRepository;
    private PaginatorInterface $paginator;

    /** @var Breadcrumbs<Breadcrumbs> */
    private Breadcrumbs $breadcrumbs;
    private MailerInterface $mailer;

    /**
     * @param Breadcrumbs<Breadcrumbs> $breadcrumbs
     */
    public function __construct(
        SecondHandProductRepository $secondHandProductRepository,
        PaginatorInterface $paginator,
        Breadcrumbs $breadcrumbs,
        MailerInterface $mailer
    ) {
        $this->secondHandProductRepository = $secondHandProductRepository;
        $this->paginator = $paginator;
        $this->breadcrumbs = $breadcrumbs;
        $this->mailer = $mailer;
    }

    /**
     * @Route("/bazar/{page}", name="product_eshop_second_hand_product_list")
     */
    public function __invoke(Request $request, int $page = 1): Response
    {
        $this->breadcrumbs->addItem('Naše nabídka');
        $this->breadcrumbs->addItem('Bazar');

        $products = $this->secondHandProductRepository->findAll();

        $pagination = $this->paginator->paginate(
            $products,
            $page,
            9
        );

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

        return $this->render(
            '@product/Eshop/SecondHandProduct/second_hand_product_list.html.twig',
            [
                'products' => $products,
                'productsPagination' => $pagination,
                'breadcrumbs' => $this->breadcrumbs,
                'form' => $form->createView(),
            ]
        );
    }
}
