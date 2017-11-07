<?php
declare(strict_types=1);

namespace Src\Product\Domain\Command;

use Src\Product\Domain\ValueObject\Discount\DiscountInterface;
use Src\Product\Domain\ValueObject\Discount\NullDiscount;
use Src\Product\Domain\ValueObject\Discount\PercentDiscount;

final class SetPercentPriceDiscount implements SetDiscountInterface
{
    /**
     * @var int|null
     */
    private $percent;

    public function __construct(?int $percent)
    {
        $this->percent = $percent;
    }

    public function getDiscount(): DiscountInterface
    {
        if ($this->percent === null) {
            return new NullDiscount();
        }

        return new PercentDiscount($this->percent);
    }
}
