<?php

declare(strict_types=1);

namespace App\Eshop\Controller;

use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class RenderCartIconController extends AbstractController
{
    private CartSessionStorage $cartSessionStorage;

    public function __construct(CartSessionStorage $cartSessionStorage)
    {
        $this->cartSessionStorage = $cartSessionStorage;
    }

    public function __invoke(): Response
    {
        $cartItemsCount = 0;
        $cartItems = $this->cartSessionStorage->getCart()->products;

        foreach ($cartItems as $cartItem) {
            $cartItemsCount += $cartItem->quantity;
        }

        return $this->render(
            'Eshop/components/_cart_icon.html.twig',
            [
                'cartItemsCount' => $cartItemsCount,
            ]
        );
    }
}
