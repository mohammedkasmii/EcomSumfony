<?php

declare(strict_types=1);

namespace App\Cart\Persister;

use App\Entity\Cart;
use App\Entity\CartItem;

interface CartPersisterInterface
{
    public function saveCart(Cart $cart): void;
    public function saveItem(CartItem $item): void;
    public function removeItem(CartItem $item): void;
    public function deleteCart(Cart $cart): void;
}
