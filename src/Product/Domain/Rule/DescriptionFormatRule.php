<?php
declare(strict_types=1);

namespace Src\Product\Domain\Rule;

use InvalidArgumentException;

final class DescriptionFormatRule
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate(string $description): void
    {
        if (mb_strlen($description) > 1000) {
            throw new InvalidArgumentException("Product description must be 1000 characters long at maximum!");
        }
    }
}
