<?php

declare(strict_types=1);

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

final readonly class CartHandler
{
    public function addToCart(CartItem $item, CartStrategyInterface $strategy, string $identifier = 'default'): Cart
    {
        $cart = $strategy->getCart($identifier);

        return $strategy->add($item, $cart);
    }

    public function removeFromCart(CartItem $item, CartStrategyInterface $strategy, string $identifier = 'default'): Cart
    {
        $cart = $strategy->getCart($identifier);

        return $strategy->remove($item, $cart);
    }

    public function getCart(CartStrategyInterface $strategy, string $identifier = 'default'): Cart
    {
        return $strategy->getCart($identifier);
    }
}
