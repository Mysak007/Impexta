<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\StoreSpecialOpeningHours;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Entity\StoreSpecialOpeningHours;
use Impexta\Store\Infrastructure\Mapper\StoreSpecialOpeningHoursMapper;
use Impexta\Store\Infrastructure\Repository\StoreSpecialOpeningHoursRepository;
use Impexta\Store\Presentation\Form\Model\StoreSpecialOpeningHoursModel;
use Impexta\Store\Presentation\Form\Type\StoreSpecialOpeningHoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class EditStoreSpecialOpeningHoursController extends AbstractController
{
    private StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository;
    private StoreSpecialOpeningHoursMapper $storeSpecialOpeningHoursMapper;

    public function __construct(
        StoreSpecialOpeningHoursMapper $storeSpecialOpeningHoursMapper,
        StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository
    ) {
        $this->storeSpecialOpeningHoursRepository = $storeSpecialOpeningHoursRepository;
        $this->storeSpecialOpeningHoursMapper = $storeSpecialOpeningHoursMapper;
    }

    /**
     * @Route("/pobocka/{id}/svatek/{openingHour}/upravit", name="store_crm_store_special_opening_hours_update")
     */
    public function __invoke(Request $request, Store $store, StoreSpecialOpeningHours $openingHours): Response
    {
        $openingHoursModel = StoreSpecialOpeningHoursModel::createFromEntity($openingHours);

        $form = $this->createForm(StoreSpecialOpeningHoursType::class, $openingHoursModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeSpecialOpeningHoursMapper->mapFromModel($openingHoursModel, $openingHours);
            $this->storeSpecialOpeningHoursRepository->save($openingHours);

            $this->addFlash('success', 'Sváteční otevírací doba byla upravena.');

            return $this->redirectToRoute(
                'store_crm_store_special_opening_hours_list',
                [
                    'id' => $store->getId(),
                ]
            );
        }

        return $this->render(
            '@store/CRM/StoreSpecialOpeningHour/store_special_opening_hour_edit.html.twig',
            [
                'form' => $form->createView(),
                'store' => $store,
                'openingHour' => $openingHours,
            ]
        );
    }
}
