<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\StoreSpecialOpeningHours;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Infrastructure\Repository\StoreSpecialOpeningHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class ListStoreSpecialOpeningHoursController extends AbstractController
{
    private StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository;

    public function __construct(
        StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository
    ) {
        $this->storeSpecialOpeningHoursRepository = $storeSpecialOpeningHoursRepository;
    }

    /**
     * @Route("/pobocka/{id}/svatky", name="store_crm_store_special_opening_hours_list")
     */
    public function __invoke(Store $store): Response
    {
        return $this->render(
            '@store/CRM/StoreSpecialOpeningHour/store_special_opening_hours_list.html.twig',
            [
                'storeSpecialOpeningHours' => $this->storeSpecialOpeningHoursRepository->findBy(['store' => $store]),
                'store' => $store,
            ]
        );
    }
}
