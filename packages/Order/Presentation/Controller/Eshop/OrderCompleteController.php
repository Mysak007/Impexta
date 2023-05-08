<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Controller\Eshop;

use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class OrderCompleteController extends AbstractController
{
    private CartSessionStorage $cartSessionStorage;

    public function __construct(CartSessionStorage $cartSessionStorage)
    {
        $this->cartSessionStorage = $cartSessionStorage;
    }

    /**
     * @Route("/orderComplete", name="order_eshop_order_complete")
     */
    public function __invoke(?UserInterface $user): Response
    {
        $cartItems = $this->cartSessionStorage->getCart();

        $currency = new Currency('CZK');

        if ($user) {
            /** @var ShopUserInterface $user */
            if ($user->getClient()) {
                $currency = $user->getClient()->getCurrency();
            }
        }

        $totalPrice = new Money(0, $currency);

        foreach ($cartItems->products as $item) {
            $totalPrice = $totalPrice->add($item->totalPrice);
        }

        return $this->render(
            '@order/Eshop/thankYouPage.html.twig',
            [
                // 'status' => 'success',
                'status' => 'paymentFail',
                // 'status' => 'fail',
                'cartItems' => $cartItems->products,
                'totalPrice' => $totalPrice,
            ]
        );
    }
}
