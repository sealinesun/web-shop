<?php
declare(strict_types=1);

namespace Src\Product\Domain\Command;

use Money\Currency;
use Money\Money;
use Src\Product\Domain\Rule\CurrencyFormatRule;
use Src\Product\Domain\ValueObject\Discount\DiscountInterface;
use Src\Product\Domain\ValueObject\Discount\FixPriceDiscount;
use Src\Product\Domain\ValueObject\Discount\NullDiscount;

final class SetFixPriceDiscount implements SetDiscountInterface
{
    /**
     * @var int|null
     */
    private $amount;

    /**
     * @var string
     */
    private $currencyCode;

    public function __construct(?int $amount, string $currencyCode)
    {
        $this->amount = $amount;
        $this->currencyCode = $currencyCode;

        $this->validate();
    }

    private function validate(): void
    {
        (new CurrencyFormatRule())->validate($this->currencyCode);
    }

    public function getDiscount(): DiscountInterface
    {
        if ($this->amount === null) {
            return new NullDiscount();
        }

        return new FixPriceDiscount(new Money($this->amount, new Currency($this->currencyCode)));
    }
}
