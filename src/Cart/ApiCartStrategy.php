<?php

declare(strict_types=1);

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

/**
 * API-based cart strategy.
 *
 * This implementation is reserved for future use when the cart
 * needs to be managed through an external API.
 */
final class ApiCartStrategy implements CartStrategyInterface
{
    public function getCart(string $identifier): Cart
    {
        throw new \LogicException('ApiCart strategy is not yet implemented.');
    }

    public function add(CartItem $item, Cart $cart): Cart
    {
        throw new \LogicException('ApiCart strategy is not yet implemented.');
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        throw new \LogicException('ApiCart strategy is not yet implemented.');
    }

    public function clearCart(string $identifier): void
    {
        throw new \LogicException('ApiCart strategy is not yet implemented.');
    }
}
