<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\Twig;

use DateTimeImmutable;
use Impexta\Product\Domain\Entity\ProductInterface;
use Impexta\Product\Infrastructure\Service\DeliveryDateResolver;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class DeliveryDateResolverExtension extends AbstractExtension
{
    private DeliveryDateResolver $deliveryDateResolver;

    public function __construct(DeliveryDateResolver $deliveryDateResolver)
    {
        $this->deliveryDateResolver = $deliveryDateResolver;
    }

    /** @return array<int, TwigFunction> */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('delivery_date', [$this, 'getDeliveryDate']),
        ];
    }

    public function getDeliveryDate(ProductInterface $product): ?DateTimeImmutable
    {
        return $this->deliveryDateResolver->getDeliveryDate($product);
    }
}
