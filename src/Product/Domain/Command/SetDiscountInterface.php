<?php
declare(strict_types=1);

namespace Src\Product\Domain\Command;

use Src\Product\Domain\ValueObject\Discount\DiscountInterface;

interface SetDiscountInterface
{
    public function getDiscount(): DiscountInterface;
}
