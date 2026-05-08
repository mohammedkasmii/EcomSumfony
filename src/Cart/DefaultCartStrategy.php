<?php

declare(strict_types=1);

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Cart\Persister\CartPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class DefaultCartStrategy implements CartStrategyInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $em,
        private CartPersisterInterface $persister
    ) {}

    public function getCart(string $identifier = 'default'): Cart
    {
        $session = $this->requestStack->getSession();
        $cartId  = $session->get('cart_id');

        if ($cartId) {
            $cart = $this->em->getRepository(Cart::class)->find($cartId);
            if ($cart) {
                return $cart;
            }
        }

        $cart = new Cart();
        $cart->setCreatedAt(new \DateTimeImmutable());
        $this->persister->saveCart($cart);

        $session->set('cart_id', $cart->getId());

        return $cart;
    }

    public function add(CartItem $item, Cart $cart): Cart
    {
        foreach ($cart->getCartItems() as $existing) {
            if ($existing->getProduct()->getId() === $item->getProduct()->getId()) {
                $existing->setQuantity($existing->getQuantity() + $item->getQuantity());
                $this->persister->saveItem($existing);

                return $cart;
            }
        }

        $item->setCart($cart);
        $this->persister->saveItem($item);

        return $cart;
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        foreach ($cart->getCartItems() as $existing) {
            if ($existing->getProduct()->getId() === $item->getProduct()->getId()) {
                $cart->removeCartItem($existing);
                $this->persister->removeItem($existing);

                return $cart;
            }
        }

        return $cart;
    }

    public function clearCart(string $identifier = 'default'): void
    {
        $session = $this->requestStack->getSession();
        $cartId  = $session->get('cart_id');

        if ($cartId) {
            $cart = $this->em->getRepository(Cart::class)->find($cartId);
            if ($cart) {
                $this->persister->deleteCart($cart);
            }
        }

        $session->remove('cart_id');
    }
}
