<?php

declare(strict_types=1);

namespace Impexta\User\Presentation\Controller\Eshop;

use Impexta\Order\Infrastructure\Repository\OrderRepository;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

final class UserDetailController extends AbstractController
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/muj-ucet", name="user_eshop_shop_user_detail")
     * @param ShopUserInterface $user
     */
    public function __invoke(SymfonyUserInterface $user): Response
    {
        $orders = $this->orderRepository->findBy([
            'client' => $user->getClient(),
        ]);

        return $this->render(
            '@user/Eshop/user_detail.html.twig',
            [
                'user' => $user,
                'orders' => $orders,
            ]
        );
    }
}
