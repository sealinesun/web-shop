<?php
declare(strict_types=1);

namespace Src\Product\Domain\ValueObject\Discount;

use Money\Money;
use Src\Product\Domain\Entity\Product;

final class PercentDiscount implements DiscountInterface
{
    /**
     * @var int
     */
    private $discountPercent;

    public function __construct(int $discountPercent)
    {
        $this->discountPercent = $discountPercent;
    }

    public function getDiscountedPrice(Product $product): Money
    {
        return $product->getListPrice()->multiply(1 - $this->discountPercent / 100);
    }
}
