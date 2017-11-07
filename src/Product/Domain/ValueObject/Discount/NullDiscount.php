<?php
declare(strict_types=1);

namespace Src\Product\Domain\ValueObject\Discount;

use Money\Money;
use Src\Product\Domain\Entity\Product;

final class NullDiscount implements DiscountInterface
{
    public function getDiscountedPrice(Product $product): Money
    {
        return $product->getListPrice();
    }
}
