<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Controller\CRM;

use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListOrderController extends AbstractController
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /** @Route("/objednavky", name="order_crm_order_list") */
    public function __invoke(): Response
    {
        $orders = $this->orderRepository->findAllOrderStatesWithoutCart();

        return $this->render('@order/crm/order_list.html.twig', [
            'orders' => $orders,
        ]);
    }
}
