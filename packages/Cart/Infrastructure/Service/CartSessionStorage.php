<?php

declare(strict_types=1);

namespace Impexta\Cart\Infrastructure\Service;

use Impexta\Cart\Api\Model\CartModel;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class CartSessionStorage
{
    private SessionInterface $session;
    private SerializerInterface $serializer;

    public function __construct(
        SessionInterface $session,
        SerializerInterface $serializer
    ) {
        $this->session = $session;
        $this->serializer = $serializer;
    }

    public function getCart(): CartModel
    {
        $cart = $this->session->get('cart', null);

        if (!$cart) {
            return $this->initializeCart();
        }

        $cart = $this->serializer->deserialize($cart, CartModel::class, 'json');

        return $cart;
    }

    public function setCart(CartModel $cart): void
    {
        $cartJson = $this->serializer->serialize($cart, 'json');
        $this->session->set('cart', $cartJson);
    }

    private function initializeCart(): CartModel
    {
        return new CartModel();
    }
}
