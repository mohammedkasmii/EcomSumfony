<?php

declare(strict_types=1);

namespace App\Tests\Unit\Cart\Handler;

use App\Cart\CartHandler;
use App\Cart\CartStrategyInterface;
use App\Entity\Cart;
use App\Entity\CartItem;
use PHPUnit\Framework\TestCase;

class CartHandlerTest extends TestCase
{
    public function testAddToCart(): void
    {
        $strategyMock = $this->createMock(CartStrategyInterface::class);
        $cart = new Cart();
        $item = new CartItem();

        $strategyMock->expects($this->once())
            ->method('getCart')
            ->with('default')
            ->willReturn($cart);

        $strategyMock->expects($this->once())
            ->method('add')
            ->with($item, $cart)
            ->willReturn($cart);

        $handler = new CartHandler();
        $result = $handler->addToCart($item, $strategyMock);

        $this->assertSame($cart, $result);
    }
}
