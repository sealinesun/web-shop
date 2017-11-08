<?php
declare(strict_types=1);

namespace Src\Cart\Infrastructure;

use InvalidArgumentException;
use Src\Base\Domain\ValueObject\Uuid;
use Src\Cart\Domain\Entity\Cart;
use Src\Cart\Domain\Repository\CartRepositoryInterface;

final class ArrayCartRepository implements CartRepositoryInterface
{
    /**
     * @var Cart[]
     */
    private $carts = [];

    /**
     * @param Cart[] $carts
     */
    public function __construct(array $carts)
    {
        foreach ($carts as $cart) {
            $this->carts[$cart->getOwnerId()->toString()] = $cart;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCart(Uuid $ownerId): Cart
    {
        $id = $ownerId->toString();

        if (isset($this->carts[$id])) {
            return $this->carts[$id];
        }

        throw new InvalidArgumentException("Cart was not found!");
    }

    public function saveCart(Cart $cart): void
    {
        $this->carts[$cart->getOwnerId()->toString()] = $cart;
    }
}
