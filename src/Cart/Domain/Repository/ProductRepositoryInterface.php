<?php
declare(strict_types=1);

namespace Src\Cart\Domain\Repository;

use Src\Cart\Domain\Entity\Cart;
use Src\Product\Domain\ValueObject\Uuid;

interface CartRepositoryInterface
{
    public function getCart(Uuid $ownerId): Cart;

    public function saveCart(Cart $cart): void;
}
