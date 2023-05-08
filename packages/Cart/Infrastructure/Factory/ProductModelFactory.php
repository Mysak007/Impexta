<?php

declare(strict_types=1);

namespace Impexta\Cart\Infrastructure\Factory;

use Impexta\Cart\Api\Model\ProductModel;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\Calculator\ProductPriceCalculator;
use Impexta\Product\Infrastructure\Repository\ProductRepository;
use Impexta\User\Domain\Entity\ShopUserInterface;
use Money\Currency;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ProductModelFactory
{
    private ProductPriceCalculator $priceCalculator;
    private Packages $assetsManager;
    private SessionInterface $session;
    private ProductRepository $productRepository;

    public function __construct(
        ProductPriceCalculator $priceCalculator,
        Packages $assetsManager,
        SessionInterface $session,
        ProductRepository $productRepository
    ) {
        $this->priceCalculator = $priceCalculator;
        $this->assetsManager = $assetsManager;
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function create(ProductInterface $product, int $quantity, ?ShopUserInterface $user): ProductModel
    {
        $productImage = $product->getMainProductImage();

        if ($productImage && $productImage->getFilename()) {
            /** @var string $path */
            $path = '/uploads/products/' . $productImage->getFilename();
            $image = $this->assetsManager->getUrl($path);
        }

        $productPrice = $this->priceCalculator->getPriceWithoutVat(
            $product,
            new Currency($this->session->get('currency')),
            $user
        );

        return new ProductModel(
            $product->getId(),
            $quantity,
            $product->getName(),
            $productPrice,
            $productPrice->multiply($quantity),
            $image ?? ''
        );
    }

    public function createFromManipulator(ProductModel $productModel, ?ShopUserInterface $user): ProductModel
    {
        /** @var ProductInterface $product */
        $product = $this->productRepository->findOneBy(['id' => $productModel->productId]);

        return $this->create($product, $productModel->quantity, $user);
    }
}
