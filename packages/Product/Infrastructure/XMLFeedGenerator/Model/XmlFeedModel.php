<?php

declare(strict_types=1);

namespace Impexta\Product\Infrastructure\XMLFeedGenerator\Model;

use DateTimeImmutable;

final class XmlFeedModel
{
    /** @var array<int,XmlFeedProductModel> $products */
    public array $products;
    public DateTimeImmutable $createdAt;

    /**
     * @param array<int,XmlFeedProductModel> $products
     */
    public function __construct(array $products, DateTimeImmutable $createdAt)
    {
        $this->products = $products;
        $this->createdAt = $createdAt;
    }
}
