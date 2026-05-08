<?php

declare(strict_types=1);

namespace App\Product\Fetcher;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Shared\DTO\Pagination;

final readonly class DefaultProductFetcher implements ProductFetcherInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    /**
     * @return Product[]
     */
    public function fetchAllWithCategoryPaginated(Pagination $pagination): array
    {
        return $this->productRepository->findAllWithCategoryPaginated(
            $pagination->page,
            $pagination->limit
        );
    }

    public function fetchById(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
