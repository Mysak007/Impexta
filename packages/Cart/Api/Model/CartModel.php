<?php

declare(strict_types=1);

namespace Impexta\Cart\Api\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

final class CartModel
{
    /**
     * @Type("ArrayCollection<Impexta\Cart\Api\Model\ProductModel>")
     * @var ArrayCollection<int,ProductModel> $products
     */
    public ArrayCollection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
}
