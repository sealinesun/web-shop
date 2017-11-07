<?php
declare(strict_types=1);

namespace Src\Cart\Infrastructure;

use InvalidArgumentException;
use Src\Cart\Domain\Entity\Cart;
use Src\Cart\Domain\Repository\CartRepositoryInterface;
use Src\Product\Domain\ValueObject\Uuid;

final class SessionCartRepository implements CartRepositoryInterface
{
    /**
     * @param Cart[] $carts
     */
    public function __construct(array $carts)
    {
        $this->startSession();

        foreach ($carts as $cart) {
            $_SESSION["carts"][$cart->getOwnerId()->toString()] = $cart;
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getCart(Uuid $ownerId): Cart
    {
        $id = $ownerId->toString();

        if (isset($_SESSION["carts"][$id])) {
            return $_SESSION["carts"][$id];
        }

        throw new InvalidArgumentException("Cart was not found!");
    }

    public function saveCart(Cart $cart): void
    {
        $_SESSION["carts"][$cart->getOwnerId()->toString()] = $cart;
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
