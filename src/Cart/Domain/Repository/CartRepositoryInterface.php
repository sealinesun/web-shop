<?php
declare(strict_types=1);

namespace Src\Cart\Domain\Repository;

use Src\Base\Domain\ValueObject\Uuid;
use Src\Cart\Domain\Entity\Cart;

interface CartRepositoryInterface
{
    public function getCart(Uuid $ownerId): Cart;

    public function saveCart(Cart $cart): void;
}
