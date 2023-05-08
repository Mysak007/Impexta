<?php

declare(strict_types=1);

namespace Impexta\Warehouse\Presentation\Controller\CRM\WarehouseIncome;

use Impexta\Warehouse\Domain\Factory\WarehouseIncomeFactory;
use Impexta\Warehouse\Infrastructure\Repository\WarehouseIncomeRepository;
use Impexta\Warehouse\Presentation\Form\Model\WarehouseIncomeModel;
use Impexta\Warehouse\Presentation\Form\Type\WarehouseIncomeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class WarehouseIncomeController extends AbstractController
{
    private WarehouseIncomeModel $warehouseIncomeModel;
    private WarehouseIncomeFactory $warehouseIncomeFactory;
    private WarehouseIncomeRepository $warehouseIncomeRepository;

    public function __construct(
        WarehouseIncomeModel $warehouseIncomeModel,
        WarehouseIncomeFactory $warehouseIncomeFactory,
        WarehouseIncomeRepository $warehouseIncomeRepository
    ) {
        $this->warehouseIncomeModel = $warehouseIncomeModel;
        $this->warehouseIncomeFactory = $warehouseIncomeFactory;
        $this->warehouseIncomeRepository = $warehouseIncomeRepository;
    }

    /**
     * @Route("/sklad/prijem", name="warehouse_crm_warehouse_income")
     */

    public function __invoke(Request $request): Response
    {
        $warehouseIncomeModel = $this->warehouseIncomeModel::createEmpty();
        $form = $this->createForm(WarehouseIncomeType::class, $warehouseIncomeModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $warehouseIncome = $this->warehouseIncomeFactory->create($warehouseIncomeModel);
            $this->warehouseIncomeRepository->save($warehouseIncome);
            $this->addFlash('success', 'Zboží bylo přijato na sklad.');

            return $this->redirectToRoute('warehouse_crm_warehouse_income');
        }

        return $this->render(
            '@warehouse/CRM/income/warehouse_income.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
