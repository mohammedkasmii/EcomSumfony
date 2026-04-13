<?php

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

class CartHandler
{
    public function addToCart(CartItem $item, CartInterface $strategy, string $identifier = 'default'): Cart
    {
        $cart = $strategy->getCart($identifier);
        return $strategy->add($item, $cart);
    }

    public function removeFromCart(CartItem $item, CartInterface $strategy, string $identifier = 'default'): Cart
    {
        $cart = $strategy->getCart($identifier);
        return $strategy->remove($item, $cart);
    }

    public function getCart(CartInterface $strategy, string $identifier = 'default'): Cart
    {
        return $strategy->getCart($identifier);
    }
}
