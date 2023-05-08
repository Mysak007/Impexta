<?php

declare(strict_types=1);

namespace Impexta\Cart\Infrastructure\CartManipulator;

use Impexta\Cart\Api\Model\CartModel;
use Impexta\Cart\Infrastructure\Factory\ProductModelFactory;
use Impexta\Cart\Infrastructure\Service\CartSessionStorage;

final class CartManipulatorFactory
{
    private ProductModelFactory $productModelFactory;
    private CartSessionStorage $cartSessionStorage;

    public function __construct(
        ProductModelFactory $productModelFactory,
        CartSessionStorage $cartSessionStorage
    ) {
        $this->productModelFactory = $productModelFactory;
        $this->cartSessionStorage = $cartSessionStorage;
    }

    public function create(CartModel $cartModel): CartManipulator
    {
        return new CartManipulator(
            $cartModel,
            $this->productModelFactory,
            $this->cartSessionStorage
        );
    }
}
