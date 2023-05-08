<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\Store;

use Impexta\Store\Domain\Entity\Store;
use Impexta\Store\Infrastructure\Mapper\StoreOpeningHoursMapper;
use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Impexta\Store\Presentation\Form\Model\StoreModel;
use Impexta\Store\Presentation\Form\Type\StoreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditStoreController extends AbstractController
{
    private StoreRepository $storeRepository;
    private StoreOpeningHoursMapper $storeOpeningHoursMapper;

    public function __construct(
        StoreRepository $storeRepository,
        StoreOpeningHoursMapper $storeOpeningHoursMapper
    ) {
        $this->storeRepository = $storeRepository;
        $this->storeOpeningHoursMapper = $storeOpeningHoursMapper;
    }

    /**
     * @Route("/pobocka/{id}/upravit", name="store_crm_store_update")
     */
    public function __invoke(Request $request, Store $store): Response
    {
        $storeModel = StoreModel::createFromEntity($store);

        $form = $this->createForm(StoreType::class, $storeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->storeOpeningHoursMapper->mapFromModel($storeModel, $store);
            $this->storeRepository->save($store);

            $this->addFlash('success', 'Pobočka ' . $store->getName() . ' byla upravena.');

            return $this->redirectToRoute('store_crm_store_list');
        }

        return $this->render(
            '@store/CRM/Store/store_edit.html.twig',
            [
                'form' => $form->createView(),
                'store' => $store,
            ]
        );
    }
}
