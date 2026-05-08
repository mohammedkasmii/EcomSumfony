<?php

declare(strict_types=1);

namespace App\Controller;

use App\Product\Fetcher\ProductFetcherInterface;
use App\Shared\DTO\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        #[MapQueryString] ?Pagination $pagination,
        ProductFetcherInterface $productFetcher
    ): Response {
        $pagination ??= new Pagination();

        return $this->render('store/index.html.twig', [
            'products' => $productFetcher->fetchAllWithCategoryPaginated($pagination),
            'page' => $pagination->page,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function productDetails(int $id, ProductFetcherInterface $productFetcher): Response
    {
        $product = $productFetcher->fetchById($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('store/product_details.html.twig', [
            'product' => $product,
        ]);
    }
}
