<?php

declare(strict_types=1);

namespace Impexta\Client\Presentation\Controller\CRM;

use Impexta\Client\Domain\Entity\Client;
use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Impexta\User\Infrastructure\Repository\ShopUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ClientDetailController extends AbstractController
{
    private OrderRepository $orderRepository;
    private ShopUserRepository $shopUserRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ShopUserRepository $shopUserRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->shopUserRepository = $shopUserRepository;
    }

    /**
     * @Route("zakaznik/{id}", name="client_crm_client_detail", requirements={"id"="\d+"})
     */
    public function __invoke(Client $client): Response
    {
        $allowRemove = true;
        $order = $this->orderRepository->findOneBy(['client' => $client]);

        if ($order) {
            $allowRemove = false;
        }

        return $this->render('@client/CRM/client_detail.html.twig', [
            'client' => $client,
            'allow_remove' => $allowRemove,
            'shopUser' => $this->shopUserRepository->findOneBy(['client' => $client]),
        ]);
    }
}
