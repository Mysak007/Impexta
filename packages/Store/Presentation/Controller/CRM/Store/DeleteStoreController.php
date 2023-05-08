<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\Store;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteStoreController extends AbstractController
{
    private StoreRepository $storeRepository;

    public function __construct(
        StoreRepository $storeRepository
    ) {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @Route("/pobocka/{id}/smazat", name="store_crm_store_delete")
     */
    public function __invoke(Store $store): RedirectResponse
    {
        $this->storeRepository->removeAndSave($store);
        $this->addFlash('warning', 'Pobočka byla odstraněna.');

        return $this->redirectToRoute('store_crm_store_list');
    }
}
