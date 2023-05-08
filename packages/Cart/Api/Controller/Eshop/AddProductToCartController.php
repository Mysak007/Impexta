<?php

declare(strict_types=1);

namespace Impexta\Cart\Api\Controller\Eshop;

use Impexta\Cart\Infrastructure\CartManipulator\CartManipulatorFactory;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\Product\Domain\Entity\Product;
use Impexta\User\Domain\Entity\ShopUserInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddProductToCartController extends AbstractController
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
     * @Route("/cart/{id}/{quantity}", methods={"POST"})
     * @ParamConverter("product", options={"id" = "id"})
     */
    public function __invoke(Product $product, int $quantity): JsonResponse
    {
        /** @var ShopUserInterface $user */
        $user = $this->getUser();
        $cart = $this->cartSessionStorage->getCart();
        $cartManipulator = $this->cartManipulatorFactory->create($cart);
        $cartManipulator->addProduct($product, $quantity, $user);
        $this->cartSessionStorage->setCart($cart);

        return new JsonResponse(
            $this->serializer->serialize($cart, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
