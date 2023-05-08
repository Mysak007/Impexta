<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseOrder;

use Impexta\User\Domain\Entity\AdminUserInterface;
use Impexta\Warehouse\Domain\Entity\WarehouseOrder;
use Impexta\Warehouse\Domain\Factory\WarehouseOrderFactory;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseOrderRepository;
use Impexta\Warehouse\Infrastructure\Security\WarehouseOrderVoter;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseOrderModel;
use Impexta\Warehouse\Presentation\Form\Type\WarehouseOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class CreateWarehouseOrderController extends AbstractController
{
    private WarehouseOrderFactory $warehouseOrderFactory;
    private WarehouseOrderRepository $warehouseOrderRepository;

    public function __construct(
        WarehouseOrderFactory $warehouseOrderFactory,
        WarehouseOrderRepository $warehouseOrderRepository
    ) {
        $this->warehouseOrderFactory = $warehouseOrderFactory;
        $this->warehouseOrderRepository = $warehouseOrderRepository;
    }

        /**
         * @Route("/sklad/objednavka/vytvorit", name="warehouse_crm_warehouse_order_create")
         * @param AdminUserInterface $user
         */
    public function __invoke(Request $request, UserInterface $user): Response
    {
        $this->denyAccessUnlessGranted(WarehouseOrderVoter::CREATE, WarehouseOrder::class);

        $model = WarehouseOrderModel::createEmpty();
        $form = $this->createForm(WarehouseOrderType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $warehouseOrder = $this->warehouseOrderFactory->create($model, $user);

            $this->warehouseOrderRepository->save($warehouseOrder);
            $this->addFlash('success', 'Objednávka na sklad byla vytvořena');

            return $this->redirectToRoute('warehouse_crm_warehouse_order_list');
        }

        return $this->render(
            '@warehouse/CRM/order/warehouse_order_create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
