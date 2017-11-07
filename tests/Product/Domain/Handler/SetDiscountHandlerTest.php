<?php
declare(strict_types=1);

namespace Tests\Product\Domain\Handler;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Product\Domain\Command\SetFixPriceDiscount;
use Src\Product\Domain\Command\SetPercentPriceDiscount;
use Src\Product\Domain\Entity\Product;
use Src\Product\Domain\Handler\SetDiscountHandler;
use Src\Product\Domain\Repository\ProductRepositoryInterface;
use Src\Product\Domain\ValueObject\Discount\NullDiscount;
use Src\Product\Infrastructure\ArrayProductRepository;

class SetDiscountHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function handle20PercentDiscount(): void
    {
        $repository = $this->createRepository();
        $handler = $this->createHandler($repository);

        $handler->handle("123", new SetPercentPriceDiscount(10));

        $product = $repository->getProduct("123");
        $this->assertEquals("900", $product->getDiscountedPrice()->getAmount());
        $this->assertEquals("EUR", $product->getDiscountedPrice()->getCurrency());
    }

    /**
     * @test
     */
    public function handleFixPriceDiscount(): void
    {
        $repository = $this->createRepository();
        $handler = $this->createHandler($repository);

        $handler->handle("124", new SetFixPriceDiscount(10, "EUR"));

        $product = $repository->getProduct("124");
        $this->assertEquals("90", $product->getDiscountedPrice()->getAmount());
        $this->assertEquals("EUR", $product->getDiscountedPrice()->getCurrency());
    }

    protected function createHandler(ProductRepositoryInterface $repository): SetDiscountHandler
    {
        return new SetDiscountHandler($repository);
    }

    private function createRepository(): ProductRepositoryInterface
    {
        return new ArrayProductRepository(
            [
                new Product(Uuid::generate(), "123", "ABCD", "Lorem Ipsum", Money::EUR(1000), new NullDiscount()),
                new Product(Uuid::generate(), "124", "EFGH", "Lorem Ipsum 2", Money::EUR(100), new NullDiscount()),
            ]
        );
    }
}
