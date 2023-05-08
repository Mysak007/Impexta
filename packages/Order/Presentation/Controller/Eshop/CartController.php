<?php

declare(strict_types=1);

namespace Impexta\Order\Presentation\Controller\Eshop;

use Impexta\Cart\Api\Model\CartModel;
use Impexta\Cart\Infrastructure\CartManipulator\CartManipulator;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\Order\Presentation\Form\Type\OrderCartType;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Money\Money;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class CartController extends AbstractController
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

    private function countTotalPrice(CartModel $cartItems, Currency $currency): Money
    {
        $totalPrice = new Money(0, $currency);

        foreach ($cartItems->products as $item) {
            $totalPrice = $totalPrice->add($item->totalPrice);
        }

        return $totalPrice;
    }

    /**
     * @Route("/kosik", name="order_eshop_order_cart")
     * @param ShopUserInterface|null $user
     */
    public function __invoke(?UserInterface $user, Request $request, SessionInterface $session): Response
    {
        $cartItems = $this->cartSessionStorage->getCart();

        $clientCars = null;
        $sessionCurrency = $session->get('currency');

        if ($sessionCurrency) {
            $currency = new Currency($sessionCurrency);
        }

        if (!$sessionCurrency) {
            $currency = new Currency('CZK');
        }

        if (
            !$cartItems->products->isEmpty() &&
            $currency->getCode() !== $cartItems->products->first()->totalPrice->getCurrency()->getCode()
        ) {
            $this->cartManipulator->changeCurrency($cartItems, $user);
            $cartItems = $this->cartSessionStorage->getCart();
        }

        if ($user && $user->getClient()) {
            $clientCars = $user->getClient()->getClientCars();
        }

        $totalPrice = $this->countTotalPrice($cartItems, $currency);

        $form = $this->createForm(OrderCartType::class, null, ['cars' => $clientCars]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chosenCar = $form->getData()['clientCars'];
            $session->set('clientCar', $chosenCar);

            return $this->redirectToRoute('order_eshop_order');
        }

        return $this->render(
            '@order/Eshop/cart.html.twig',
            [
                'clientCars' => $clientCars,
                'cartItems' => $cartItems->products,
                'totalPrice' => $totalPrice,
                'form' => $form->createView(),
            ]
        );
    }
}
