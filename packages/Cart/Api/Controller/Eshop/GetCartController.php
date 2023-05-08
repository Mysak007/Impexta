<?php

declare(strict_types=1);

namespace Impexta\Cart\Api\Controller\Eshop;

use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetCartController
{
    private SerializerInterface $serializer;
    private CartSessionStorage $cartSessionStorage;

    public function __construct(SerializerInterface $serializer, CartSessionStorage $cartSessionStorage)
    {
        $this->serializer = $serializer;
        $this->cartSessionStorage = $cartSessionStorage;
    }

    /**
     * @Route("/cart", path="cart_eshop_get_cart")
     */
    public function __invoke(): JsonResponse
    {
        $cart = $this->cartSessionStorage->getCart();

        return new JsonResponse(
            $this->serializer->serialize($cart, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
