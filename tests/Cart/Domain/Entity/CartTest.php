<?php
declare(strict_types=1);

namespace Tests\Cart\Domain\Handler;

use Money\Money;
use PHPUnit\Framework\TestCase;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Cart\Domain\Entity\Cart;
use Src\Cart\Domain\ValueObject\Item;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function addNewItem(): void
    {
        $cart = $this->createCart();

        $cart->addItem(new Item("125", "C", Money::EUR(100), 1));

        $this->assertInstanceOf(Item::class, $cart->getItem("125"));
    }

    /**
     * @test
     */
    public function addExistingItem(): void
    {
        $cart = $this->createCart();

        $cart->addItem(new Item("123", "C", Money::EUR(600), 3));

        $this->assertEquals(4, $cart->getItem("123")->getQuantity());
        $this->assertEquals("600", $cart->getItem("123")->getProductPrice()->getAmount());
    }

    private function createCart(array $params = []): Cart
    {
        return new Cart(
            $params["ownerId"] ?? Uuid::generate(),
            $params["items"] ?? [
                new Item("123", "A", Money::EUR(500), 1),
                new Item("124", "B", Money::EUR(1000), 2),
            ]
        );
    }
}
