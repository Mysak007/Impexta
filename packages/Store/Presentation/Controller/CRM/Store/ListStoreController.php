<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\Store;

use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListStoreController extends AbstractController
{
    private StoreRepository $storeRepository;

    public function __construct(
        StoreRepository $storeRepository
    ) {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @Route("/pobocky", name="store_crm_store_list")
     */
    public function __invoke(): Response
    {
        return $this->render(
            '@store/CRM/Store/store_list.html.twig',
            [
                'stores' => $this->storeRepository->findAll(),
            ]
        );
    }
}
