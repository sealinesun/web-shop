<?php
declare(strict_types=1);

namespace Src\Product\Domain\Rule;

use InvalidArgumentException;

final class CurrencyFormatRule
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate(string $currencyCode): void
    {
        if (in_array($currencyCode, ["CHF", "EUR", "USD"], true) === false) {
            throw new InvalidArgumentException("Valid currencies are: CHF, EUR, USD!");
        }
    }
}
