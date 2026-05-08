<?php

declare(strict_types=1);

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;

interface CartStrategyInterface
{
    public function add(CartItem $item, Cart $cart): Cart;
    public function remove(CartItem $item, Cart $cart): Cart;
    public function getCart(string $identifier): Cart;
    public function clearCart(string $identifier): void;
}
