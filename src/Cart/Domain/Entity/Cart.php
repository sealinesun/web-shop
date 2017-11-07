<?php
declare(strict_types=1);

namespace Src\Cart\Domain\Entity;

use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Cart\Domain\ValueObject\Item;

final class Cart
{
    /**
     * @var Uuid
     */
    private $ownerId;

    /**
     * @var Item[]
     */
    private $items;

    /**
     * @var Currency|null
     */
    private $currency;

    /**
     * @param Item[] $items
     */
    public function __construct(Uuid $ownerId, array $items)
    {
        $this->ownerId = $ownerId;
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @return Uuid
     */
    public function getOwnerId(): Uuid
    {
        return $this->ownerId;
    }

    public function getSumValue(): ?Money
    {
        if (empty($this->items)) {
            return null;
        }

        $sum = new Money(0, $this->currency);

        foreach ($this->items as $item) {
            $sum->add($item->getProductPrice());
        }

        return $sum;
    }

    public function addItem(Item $item): void
    {
        $productSku = $item->getProductSku();

        if ($this->currency === null) {
            $this->currency = $item->getProductPrice()->getCurrency();
        }

        if (isset($this->items[$productSku])) {
            $this->items[$productSku] = $this->items[$productSku]->withMergedItems($item);
        } else {
            $this->items[$productSku] = $item;
        }
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return array_values($this->items);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getItem(string $productSku): Item
    {
        if (isset($this->items[$productSku])) {
            return $this->items[$productSku];
        }

        throw new InvalidArgumentException("Cart was not found!");
    }
}
