<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\StoreSpecialOpeningHours;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;
use Impexta\Store\Infrastructure\Repository\StoreSpecialOpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class DeleteStoreSpecialOpeningHoursController extends AbstractController
{
    private StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository;

    public function __construct(
        StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository
    ) {
        $this->storeSpecialOpeningHoursRepository = $storeSpecialOpeningHoursRepository;
    }

    /**
     * @Route("/pobocka/{id}/svatek/{openingHour}/smazat", name="store_crm_store_special_opening_hours_delete")
     */
    public function __invoke(Store $store, StoreSpecialOpeningHours $openingHours): RedirectResponse
    {
        $this->storeSpecialOpeningHoursRepository->removeAndSave($openingHours);
        $this->addFlash('warning', 'Sváteční otevírací doba byla odstraněna.');

        return $this->redirectToRoute(
            'store_crm_store_special_opening_hours_list',
            [
                'id' => $store->getId(),
            ]
        );
    }
}
