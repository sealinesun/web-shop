<?php
declare(strict_types=1);

namespace Src\Product\Infrastructure;

use Src\Product\Domain\Entity\Product;
use Src\Product\Domain\Repository\ProductRepositoryInterface;
use Src\Product\Exception\ProductNotFound;

final class ArrayProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product[]
     */
    private $products = [];

    /**
     * @param Product[] $products
     */
    public function __construct(array $products)
    {
        foreach ($products as $product) {
            $this->products[$product->getSku()] = $product;
        }
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return array_values($this->products);
    }

    public function getProduct(string $sku): Product
    {
        if (isset($this->products[$sku])) {
            return $this->products[$sku];
        }

        throw new ProductNotFound($sku);
    }

    public function saveProduct(Product $product): void
    {
        $this->products[$product->getSku()] = $product;
    }
}
