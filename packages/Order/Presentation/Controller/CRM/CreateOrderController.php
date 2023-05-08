<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Controller\CRM;

use Impexta\Order\Domain\Factory\OrderFactory;
use Impexta\Order\Domain\Model\OrderModel as MainOrderModel;
use Impexta\Order\Infrastructure\Mapper\CRM\OrderModelMapper;
use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Impexta\Order\Presentation\Form\CRM\Model\OrderModel;
use Impexta\Order\Presentation\Form\CRM\Type\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateOrderController extends AbstractController
{
    private OrderModelMapper $orderModelMapper;
    private OrderFactory $orderFactory;
    private OrderRepository $orderRepository;

    public function __construct(
        OrderModelMapper $orderModelMapper,
        OrderFactory $orderFactory,
        OrderRepository $orderRepository
    ) {
        $this->orderModelMapper = $orderModelMapper;
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
    }

    /** @Route("objednavka/vytvorit", name="order_crm_order_create") */
    public function __invoke(Request $request): Response
    {
        $mainOrderModel = MainOrderModel::createEmpty();
        $orderModel = OrderModel::createEmpty();
        $form = $this->createForm(OrderType::class, $orderModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->selectedShippingAddress === null) {
                $orderModel->filledInShippingAddress = $form->getData()->filledInShippingAddress;
            }

            $this->orderModelMapper->mapFromCrmModel($mainOrderModel, $orderModel);
            $order = $this->orderFactory->create($mainOrderModel);

            $this->orderRepository->save($order);
            $this->addFlash('success', 'Objednávka byla úspěšně vytvořena');

            return $this->redirectToRoute('order_crm_order_list');
        }

        return $this->render('@order/crm/order_create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
