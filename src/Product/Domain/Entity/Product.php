<?php
declare(strict_types=1);

namespace Src\Product\Domain\Entity;

use Money\Money;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Product\Domain\Command\EditDetails;
use Src\Product\Domain\Command\NewProduct;
use Src\Product\Domain\ValueObject\Discount\DiscountInterface;
use Src\Product\Domain\ValueObject\Discount\NullDiscount;

final class Product
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Money
     */
    private $price;

    /**
     * @var DiscountInterface
     */
    private $discount;

    public static function create(NewProduct $newProduct): Product
    {
        return new Product(
            Uuid::generate(),
            $newProduct->getSku(),
            $newProduct->getTitle(),
            $newProduct->getDescription(),
            $newProduct->getPrice(),
            new NullDiscount()
        );
    }

    public function __construct(
        Uuid $id,
        string $sku,
        string $title,
        string $description,
        Money $price,
        DiscountInterface $discount
    ) {
        $this->id = $id;
        $this->sku = $sku;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->discount = $discount;
    }

    public function editDetails(EditDetails $command): void
    {
        $this->title = $command->getTitle();
        $this->description = $command->getDescription();
        $this->price = $command->getPrice();
    }

    public function discount(DiscountInterface $discount): void
    {
        $this->discount = $discount;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getListPrice(): Money
    {
        return $this->price;
    }

    public function getDiscountedPrice(): Money
    {
        return $this->discount->getDiscountedPrice($this);
    }

    public function hasDiscount(): bool
    {
        return $this->discount->getDiscountedPrice($this)->equals($this->price) === false;
    }
}
