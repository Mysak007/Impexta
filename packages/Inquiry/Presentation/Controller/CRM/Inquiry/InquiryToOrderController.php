<?php

declare(strict_types=1);

namespace Impexta\Inquiry\Presentation\Controller\CRM\Inquiry;

use Impexta\Inquiry\Domain\Entity\Inquiry;
use Impexta\Inquiry\Presentation\Form\Model\InquiryCreateOrderModel;
use Impexta\Inquiry\Presentation\Form\Type\InquiryCreateOrderType;
use Impexta\Order\Domain\Event\OrderCreated;
use Impexta\Order\Domain\Factory\OrderFactory;
use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InquiryToOrderController extends AbstractController
{
    private OrderFactory $orderFactory;
    private OrderRepository $orderRepository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        OrderFactory $orderFactory,
        OrderRepository $orderRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/poptavka/{id}/objednat", name="inquiry_crm_inquiry_to_order")
     */
    public function __invoke(Inquiry $inquiry, Request $request): Response
    {
        $createOrderModel = InquiryCreateOrderModel::createFromEntity($inquiry);
        $createOrderForm = $this->createForm(InquiryCreateOrderType::class, $createOrderModel);
        $createOrderForm->handleRequest($request);

        if ($createOrderForm->isSubmitted() && $createOrderForm->isValid()) {
            $order = $this->orderFactory->createFromInquiry(
                $inquiry,
                $createOrderModel
            );

            $event = new OrderCreated($order);
            $this->dispatcher->dispatch($event);

            $this->orderRepository->save($order);

            $this->addFlash('success', 'Objednávka byla úspěšna vytvořena.');

            return $this->redirectToRoute('inquiry_crm_inquiry_list');
        }

        return $this->render(
            '@inquiry/CRM/inquiry/inquiry_order.html.twig',
            [
                'inquiry' => $inquiry,
                'create_order_form' => $createOrderForm->createView(),
            ]
        );
    }
}
