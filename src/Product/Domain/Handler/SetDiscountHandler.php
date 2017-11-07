<?php
declare(strict_types=1);

namespace Src\Product\Domain\Handler;

use Src\Product\Domain\Command\SetDiscountInterface;
use Src\Product\Domain\Repository\ProductRepositoryInterface;

final class SetDiscountHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $sku, SetDiscountInterface $command): void
    {
        $product = $this->repository->getProduct($sku);

        $product->discount($command->getDiscount());
    }
}
