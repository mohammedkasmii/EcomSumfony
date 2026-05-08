<?php

declare(strict_types=1);

namespace App\Controller;

use App\Category\Fetcher\CategoryFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function categories(CategoryFetcherInterface $categoryFetcher): Response
    {
        return $this->render('store/browse_categories.html.twig', [
            'categories' => $categoryFetcher->fetchAll(),
        ]);
    }

    #[Route('/categories/{slug}', name: 'app_products_by_category')]
    public function productsByCategory(string $slug, CategoryFetcherInterface $categoryFetcher): Response
    {
        $category = $categoryFetcher->fetchBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        return $this->render('store/products_by_category.html.twig', [
            'category' => $category,
            'products' => $category->getProducts(),
        ]);
    }
}
