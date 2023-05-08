<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderFooterStoresController extends AbstractController
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function __invoke(): Response
    {
        $stores = $this->storeRepository->findAll();

        return $this->render(
            'Eshop/components/_footer_stores.html.twig',
            [
                'stores' => $stores,
            ]
        );
    }
}
