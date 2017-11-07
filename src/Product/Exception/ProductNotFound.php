<?php
declare(strict_types=1);

namespace Src\Product\Exception;

use Exception;

final class ProductNotFound extends Exception
{
    public function __construct(string $sku)
    {
        parent::__construct("Product with SKU '$sku' was not found!");
    }
}
