<?php

declare(strict_types=1);

namespace App\Cart\Persister;

use App\Entity\Cart;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DefaultCartPersister implements CartPersisterInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function saveCart(Cart $cart): void
    {
        $this->em->persist($cart);
        $this->em->flush();
    }

    public function saveItem(CartItem $item): void
    {
        $this->em->persist($item);
        $this->em->flush();
    }

    public function removeItem(CartItem $item): void
    {
        $this->em->remove($item);
        $this->em->flush();
    }

    public function deleteCart(Cart $cart): void
    {
        foreach ($cart->getCartItems() as $item) {
            $this->em->remove($item);
        }
        $this->em->remove($cart);
        $this->em->flush();
    }
}
