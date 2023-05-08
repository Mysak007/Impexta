<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\StoreSpecialOpeningHours;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Domain\Factory\StoreSpecialOpeningHoursFactory;
use Impexta\Store\Infrastructure\Repository\StoreSpecialOpeningHoursRepository;
use Impexta\Store\Presentation\Form\Model\StoreSpecialOpeningHoursModel;
use Impexta\Store\Presentation\Form\Type\StoreSpecialOpeningHoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @SuppressWarnings("PHPMD.LongVariable") */
final class CreateStoreSpecialOpeningHoursController extends AbstractController
{
    private StoreSpecialOpeningHoursFactory $storeSpecialOpeningHoursFactory;
    private StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository;

    public function __construct(
        StoreSpecialOpeningHoursFactory $storeSpecialOpeningHoursFactory,
        StoreSpecialOpeningHoursRepository $storeSpecialOpeningHoursRepository
    ) {
        $this->storeSpecialOpeningHoursFactory = $storeSpecialOpeningHoursFactory;
        $this->storeSpecialOpeningHoursRepository = $storeSpecialOpeningHoursRepository;
    }

    /**
     * @Route("/pobocka/{id}/svatek/vytvorit", name="store_crm_store_special_opening_hours_create")
     */
    public function __invoke(Request $request, Store $store): Response
    {
        $openingHoursModel = StoreSpecialOpeningHoursModel::createEmpty();
        $form = $this->createForm(StoreSpecialOpeningHoursType::class, $openingHoursModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $openingHour = $this->storeSpecialOpeningHoursFactory->create($openingHoursModel, $store);
            $this->storeSpecialOpeningHoursRepository->save($openingHour);
            $this->addFlash('success', 'Sváteční otevírací doba byla vytvořena.');

            return $this->redirectToRoute(
                'store_crm_store_special_opening_hours_list',
                [
                    'id' => $store->getId(),
                ]
            );
        }

        return $this->render(
            '@store/CRM/StoreSpecialOpeningHour/store_special_opening_hour_create.html.twig',
            [
                'form' => $form->createView(),
                'store' => $store,
            ]
        );
    }
}
