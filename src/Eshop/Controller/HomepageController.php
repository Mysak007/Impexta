<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Impexta\ContactForm\Domain\Factory\ContactFormFactory;
use Impexta\ContactForm\Infrastructure\Repository\ContactFormRepository;
use Impexta\ContactForm\Presentation\Form\Model\ContactFormModel;
use Impexta\ContactForm\Presentation\Form\Type\ContactFormType;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    private ContactFormRepository $contactFormRepository;
    private ContactFormFactory $contactFormFactory;
    private ProductRepository $productRepository;

    public function __construct(
        ContactFormRepository $contactFormRepository,
        ContactFormFactory $contactFormFactory,
        ProductRepository $productRepository
    ) {
        $this->contactFormRepository = $contactFormRepository;
        $this->contactFormFactory = $contactFormFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="eshop_homepage")
     */
    public function __invoke(Request $request): Response
    {
        $products = $this->productRepository->findRandomProductsForEshop();
        $contactFormModel = ContactFormModel::createEmpty();
        $form = $this->createForm(ContactFormType::class, $contactFormModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactForm = $this->contactFormFactory->create($contactFormModel);
            $this->contactFormRepository->save($contactForm);

            $this->addFlash('success', 'Zpráva byla odeslána.');

            return $this->redirectToRoute('eshop_homepage');
        }

        return $this->render(
            'Eshop/homepage.html.twig',
            [
                'form' => $form->createView(),
                'products' => $products,
            ]
        );
    }
}
