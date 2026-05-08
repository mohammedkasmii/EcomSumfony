<?php

declare(strict_types=1);

namespace App\Controller;

use App\Cart\CartHandler;
use App\Cart\CartStrategyInterface;
use App\Cart\DefaultCartStrategy;
use App\Entity\CartItem;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(
        private readonly CartHandler $cartHandler,
        #[Autowire(service: DefaultCartStrategy::class)]
        private readonly CartStrategyInterface $cartStrategy
    ) {}

    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {
        $cart = $this->cartHandler->getCart($this->cartStrategy);

        return $this->render('store/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function addToCart(int $id, Request $request, ProductRepository $productRepository): Response
    {
        if (!$this->isCsrfTokenValid('add_item', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $quantity = (int) $request->request->get('quantity', 1);

        $item = new CartItem();
        $item->setProduct($product);
        $item->setPrice($product->getPrice());
        $item->setQuantity($quantity);

        $this->cartHandler->addToCart($item, $this->cartStrategy);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function removeFromCart(int $id, Request $request, ProductRepository $productRepository): Response
    {
        if (!$this->isCsrfTokenValid('remove_item', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $item = new CartItem();
        $item->setProduct($product);

        $this->cartHandler->removeFromCart($item, $this->cartStrategy);

        return $this->redirectToRoute('app_cart');
    }
}
