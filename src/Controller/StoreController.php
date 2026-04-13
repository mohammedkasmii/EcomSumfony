<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Cart\CartInterface;
use App\Cart\SessionCart;
use App\Entity\CartItem;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Attribute\Route;

class StoreController extends AbstractController
{
    public function __construct(
        private CartHandler $cartHandler,
        #[Autowire(service: SessionCart::class)]
        private CartInterface $cartStrategy
    ) {}

    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('store/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }


    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('store/profile.html.twig');
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('store/browse_categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/categories/{slug}', name: 'app_products_by_category')]
    public function productsByCategory(string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        return $this->render('store/products_by_category.html.twig', [
            'category' => $category,
            'products' => $category->getProducts(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function productDetails(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('store/product_details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
public function addToCart(int $id, Request $request, ProductRepository $productRepository): Response
{
    $product  = $productRepository->find($id);
    $quantity = (int) $request->request->get('quantity', 1);

    $item = new CartItem();
    $item->setProduct($product);
    $item->setPrice($product->getPrice());
    $item->setQuantity($quantity);

    $this->cartHandler->addToCart($item, $this->cartStrategy);

    return $this->redirectToRoute('app_cart');
}

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
public function removeFromCart(int $id, ProductRepository $productRepository): Response
{
    $product = $productRepository->find($id);

    $item = new CartItem();
    $item->setProduct($product);

    $this->cartHandler->removeFromCart($item, $this->cartStrategy);

    return $this->redirectToRoute('app_cart');
}

    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {
        $cart = $this->cartHandler->getCart($this->cartStrategy);

        return $this->render('store/cart.html.twig', [
            'cart' => $cart,
        ]);
    }
}
