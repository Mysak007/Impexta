<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Controller\Eshop;

use Impexta\Cart\Infrastructure\CartManipulator\CartManipulator;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class OrderController extends AbstractController
{
    private CartSessionStorage $cartSessionStorage;
    private CartManipulator $cartManipulator;

    public function __construct(
        CartSessionStorage $cartSessionStorage,
        CartManipulator $cartManipulator
    ) {
        $this->cartSessionStorage = $cartSessionStorage;
        $this->cartManipulator = $cartManipulator;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @param ShopUserInterface|null $user
     * @Route("/objednavka", name="order_eshop_order")
     */
    public function __invoke(SessionInterface $session, ?UserInterface $user): Response
    {
        //TODO předávat clientCar do objednávky jako poznámku
        $clientCar = $session->get('clientCar');
        $sessionCurrency = $session->get('currency');

        if ($sessionCurrency) {
            $currency = new Currency($sessionCurrency);
        }

        if (!$sessionCurrency) {
            $currency = new Currency('CZK');
        }

        $cartItems = $this->cartSessionStorage->getCart();

        if (
            !$cartItems->products->isEmpty() &&
            $currency->getCode() !== $cartItems->products->first()->totalPrice->getCurrency()->getCode()
        ) {
            $this->cartManipulator->changeCurrency($cartItems, $user);
            $cartItems = $this->cartSessionStorage->getCart();
        }

        $totalPrice = new Money(0, $currency);

        foreach ($cartItems->products as $item) {
            $totalPrice = $totalPrice->add($item->totalPrice);
        }

        return $this->render(
            '@order/Eshop/order.html.twig',
            [
                'cartItems' => $cartItems->products,
                'totalPrice' => $totalPrice,
            ]
        );
    }
}
