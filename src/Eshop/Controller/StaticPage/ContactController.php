<?php

declare(strict_types=1);

namespace App\Eshop\Controller\StaticPage;

use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ContactController extends AbstractController
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @Route("/kontakt", name="eshop_static_page_contact")
     */
    public function __invoke(): Response
    {
        $stores = $this->storeRepository->findAll();

        return $this->render(
            'Eshop/static_page/contact.html.twig',
            [
                'stores' => $stores,
            ]
        );
    }
}
