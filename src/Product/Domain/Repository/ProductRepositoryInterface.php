<?php
declare(strict_types=1);

namespace Src\Product\Domain\Repository;

use Src\Product\Domain\Entity\Product;
use Src\Product\Exception\ProductNotFound;

interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function getProducts(): array;

    /**
     * @throws ProductNotFound
     */
    public function getProduct(string $sku): Product;

    public function saveProduct(Product $product): void;
}
