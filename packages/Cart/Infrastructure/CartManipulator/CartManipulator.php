<?php

declare(strict_types=1);

namespace Impexta\Cart\Infrastructure\CartManipulator;

use Impexta\Cart\Api\Model\CartModel;
use Impexta\Cart\Infrastructure\Factory\ProductModelFactory;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\User\Domain\Entity\ShopUserInterface;

final class CartManipulator
{
    private CartModel $cart;
    private ProductModelFactory $productModelFactory;
    private CartSessionStorage $cartSessionStorage;

    public function __construct(
        CartModel $cart,
        ProductModelFactory $productModelFactory,
        CartSessionStorage $cartSessionStorage
    ) {
        $this->cart = $cart;
        $this->productModelFactory = $productModelFactory;
        $this->cartSessionStorage = $cartSessionStorage;
    }

    public function addProduct(ProductInterface $product, int $quantity, ?ShopUserInterface $user): void
    {
        $foundProduct = $this->cart->products->filter(static function ($entityProduct) use ($product) {
            return (string)$entityProduct->productId === (string)$product->getId();
        })->first();

        if ($foundProduct) {
            $foundProduct->quantity += $quantity;
            $foundProduct->totalPrice = $foundProduct->unitPrice->multiply($foundProduct->quantity);

            return;
        }

        $newProduct = $this->productModelFactory->create($product, $quantity, $user);
        $this->cart->products->add($newProduct);
    }

    public function removeProduct(ProductInterface $product, int $quantity): void
    {
        $foundProduct = $this->cart->products->filter(static function ($entityProduct) use ($product) {
            return (string)$entityProduct->productId === (string)$product->getId();
        })->first();

        if (!$foundProduct) {
            return;
        }

        $foundProduct->quantity -= $quantity;
        $foundProduct->totalPrice = $foundProduct->unitPrice->multiply($foundProduct->quantity);

        if ($foundProduct->quantity > 0) {
            return;
        }

        $this->cart->products->removeElement($foundProduct);
    }

    public function clearCart(): void
    {
        $this->cart->products->clear();
    }

    public function changeCurrency(CartModel $cartModel, ?ShopUserInterface $user): void
    {
        $newCart = new CartModel();

        foreach ($cartModel->products as $product) {
            $newProduct = $this->productModelFactory->createFromManipulator($product, $user);
            $newCart->products->add($newProduct);
        }

        $cartModel = $newCart;
        $this->cartSessionStorage->setCart($cartModel);
    }
}
