<?php

declare(strict_types=1);

namespace Impexta\Store\Presentation\Controller\CRM\Store;

use Impexta\Store\Domain\Factory\StoreFactory;
use Impexta\Store\Infrastructure\Repository\StoreRepository;
use Impexta\Store\Presentation\Form\Model\StoreModel;
use Impexta\Store\Presentation\Form\Type\StoreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateStoreController extends AbstractController
{
    private StoreRepository $storeRepository;
    private StoreFactory $storeFactory;

    public function __construct(StoreFactory $storeFactory, StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
        $this->storeFactory = $storeFactory;
    }

    /**
     * @Route("/pobocka/vytvorit", name="store_crm_store_create")
     */
    public function __invoke(Request $request): Response
    {
        $storeModel = new StoreModel();
        $form = $this->createForm(StoreType::class, $storeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store = $this->storeFactory->create($storeModel);
            $this->storeRepository->save($store);
            $this->addFlash('success', 'Pobočka byla vytvořena.');

            return $this->redirectToRoute('store_crm_store_list');
        }

        return $this->render(
            '@store/CRM/Store/store_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
