<?php
declare(strict_types=1);

namespace Src\Cart\Domain\ValueObject;

use InvalidArgumentException;
use Money\Money;
use Src\Product\Domain\Entity\Product;

final class Item
{
    /**
     * @var string
     */
    private $productSku;

    /**
     * @var string
     */
    private $productTitle;

    /**
     * @var Money
     */
    private $productPrice;

    /**
     * @var int
     */
    private $quantity;

    public static function createFromProduct(Product $product, int $quantity): Item
    {
        return new Item(
            $product->getSku(),
            $product->getTitle(),
            $product->getDiscountedPrice(),
            $quantity
        );
    }

    public function __construct(string $productSku, $productTitle, Money $productPrice, $quantity)
    {
        $this->productSku = $productSku;
        $this->productTitle = $productTitle;
        $this->productPrice = $productPrice;
        $this->quantity = $quantity;
    }

    public function withMergedItems(Item $item): Item
    {
        if ($this->productSku !== $item->productSku) {
            throw new InvalidArgumentException("The products do not match!");
        }

        $self = clone $this;
        $self->quantity += $item->getQuantity();
        $self->productPrice += $item->getProductPrice();

        return $self;
    }

    public function getProductSku(): string
    {
        return $this->productSku;
    }

    public function getProductTitle(): string
    {
        return $this->productTitle;
    }

    public function getProductPrice(): Money
    {
        return $this->productPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
