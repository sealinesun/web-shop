<?php
declare(strict_types=1);

namespace Src\Product\Domain\Rule;

use InvalidArgumentException;

final class TitleFormatRule
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate(string $title): void
    {
        if (empty($title) || mb_strlen($title) > 100) {
            throw new InvalidArgumentException("Product title must be between 1-100 characters long!");
        }
    }
}
