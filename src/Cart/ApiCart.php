<?php

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

class ApiCart implements CartInterface
{
    public function getCart(string $identifier): Cart
    {
        dd('ApiCart::getCart called', $identifier);
    }

    public function add(CartItem $item, Cart $cart): Cart
    {
        dd('ApiCart::add called', $item, $cart);
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        dd('ApiCart::remove called', $item, $cart);
    }

    public function clearCart(string $identifier): void
    {
        dd('ApiCart::clearCart called', $identifier);
    }
}
