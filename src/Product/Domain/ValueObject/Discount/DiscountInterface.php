<?php
declare(strict_types=1);

namespace Src\Product\Domain\ValueObject\Discount;

use Money\Money;
use Src\Product\Domain\Entity\Product;

interface DiscountInterface
{
    public function getDiscountedPrice(Product $product): Money;
}
