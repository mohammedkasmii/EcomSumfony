<?php

namespace App\Cart;

use App\Entity\Cart;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $em
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

        // Créer un nouveau panier et le persister
        $cart = new Cart();
        $cart->setCreatedAt(new \DateTime());
        $this->em->persist($cart);
        $this->em->flush();

        $session->set('cart_id', $cart->getId());

        return $cart;
    }

    public function add(CartItem $item, Cart $cart): Cart
    {
        // Vérifier si le produit existe déjà dans le panier
        foreach ($cart->getCartItems() as $existing) {
            if ($existing->getProduct()->getId() === $item->getProduct()->getId()) {
                $existing->setQuantity($existing->getQuantity() + $item->getQuantity());
                $this->em->flush();
                return $cart;
            }
        }

        $item->setCart($cart);
        $this->em->persist($item);
        $this->em->flush();

        return $cart;
    }

    public function remove(CartItem $item, Cart $cart): Cart
    {
        foreach ($cart->getCartItems() as $existing) {
            if ($existing->getProduct()->getId() === $item->getProduct()->getId()) {
                $cart->removeCartItem($existing);
                $this->em->remove($existing);
                $this->em->flush();
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
                foreach ($cart->getCartItems() as $item) {
                    $this->em->remove($item);
                }
                $this->em->remove($cart);
                $this->em->flush();
            }
        }

        $session->remove('cart_id');
    }
}
