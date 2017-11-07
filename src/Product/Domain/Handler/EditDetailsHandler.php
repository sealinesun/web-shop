<?php
declare(strict_types=1);

namespace Src\Product\Domain\Handler;

use Src\Product\Domain\Command\EditDetails;
use Src\Product\Domain\Repository\ProductRepositoryInterface;

final class EditDetailsHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $sku, EditDetails $command): void
    {
        $product = $this->repository->getProduct($sku);

        $product->editDetails($command);
    }
}
