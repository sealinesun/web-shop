<?php
declare(strict_types=1);

namespace Tests\Product\Domain\Handler;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Product\Domain\Command\EditDetails;
use Src\Product\Domain\Entity\Product;
use Src\Product\Domain\Handler\SetDiscountHandler;
use Src\Product\Domain\Repository\ProductRepositoryInterface;
use Src\Product\Domain\ValueObject\Discount\NullDiscount;
use Src\Product\Domain\ValueObject\Discount\PercentDiscount;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function discountWith20Percent(): void
    {
        $product = $this->createProduct();

        $product->discount(new PercentDiscount(20));

        $this->assertEquals("1000", $product->getListPrice()->getAmount());
        $this->assertEquals("EUR", $product->getListPrice()->getCurrency());

        $this->assertEquals("800", $product->getDiscountedPrice()->getAmount());
        $this->assertEquals("EUR", $product->getDiscountedPrice()->getCurrency());
    }

    /**
     * @test
     */
    public function editDetails(): void
    {
        $product = $this->createProduct();

        $product->editDetails(new EditDetails("XYZ", "", 2000, "EUR"));

        $this->assertEquals("XYZ", $product->getTitle());
        $this->assertEquals("", $product->getDescription());
        $this->assertEquals("2000", $product->getListPrice()->getAmount());
        $this->assertEquals("EUR", $product->getListPrice()->getCurrency());
    }

    protected function createHandler(ProductRepositoryInterface $repository): SetDiscountHandler
    {
        return new SetDiscountHandler($repository);
    }

    private function createProduct(array $params = []): Product
    {
        return new Product(
            $params["id"] ?? Uuid::generate(),
            $params["sku"] ?? "123",
            $params["title"] ?? "ABCD",
            $params["description"] ?? "Lorem ipsum",
            $params["price"] ?? new Money(1000, new Currency("EUR")),
            $params["discount"] ?? new NullDiscount()
        );
    }
}
