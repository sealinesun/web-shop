<?php
declare(strict_types=1);

namespace Src\Product\Domain\ValueObject\Discount;

use InvalidArgumentException;
use Money\Money;
use Src\Product\Domain\Entity\Product;

final class FixPriceDiscount implements DiscountInterface
{
    /**
     * @var Money
     */
    private $discount;

    public function __construct(Money $discount)
    {
        $this->discount = $discount;
    }

    public function getDiscountedPrice(Product $product): Money
    {
        if ($product->getListPrice()->isSameCurrency($this->discount) === false) {
            throw new InvalidArgumentException("The discount has a different currency than the product price!");
        }

        if ($product->getListPrice()->lessThanOrEqual($this->discount)) {
            throw new InvalidArgumentException("The discount is more than the product price!!");
        }

        return $product->getListPrice()->subtract($this->discount);
    }
}
