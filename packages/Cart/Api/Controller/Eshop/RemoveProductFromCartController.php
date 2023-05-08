<?php

declare(strict_types=1);

namespace Impexta\Cart\Api\Controller\Eshop;

use Impexta\Cart\Infrastructure\CartManipulator\CartManipulatorFactory;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\Product\Domain\Entity\Product;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveProductFromCartController
{
    private SerializerInterface $serializer;
    private CartSessionStorage $cartSessionStorage;
    private CartManipulatorFactory $cartManipulatorFactory;

    public function __construct(
        SerializerInterface $serializer,
        CartSessionStorage $cartSessionStorage,
        CartManipulatorFactory $cartManipulatorFactory
    ) {
        $this->serializer = $serializer;
        $this->cartSessionStorage = $cartSessionStorage;
        $this->cartManipulatorFactory = $cartManipulatorFactory;
    }

    /**
     * @Route("/cart/{id}/{quantity}", methods={"DELETE"})
     * @ParamConverter("product", options={"id" = "id"})
     */
    public function __invoke(Product $product, int $quantity): JsonResponse
    {
        $cart = $this->cartSessionStorage->getCart();
        $cartManipulator = $this->cartManipulatorFactory->create($cart);
        $cartManipulator->removeProduct($product, $quantity);
        $this->cartSessionStorage->setCart($cart);

        return new JsonResponse(
            $this->serializer->serialize($cart, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
