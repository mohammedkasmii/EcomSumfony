<?php

declare(strict_types=1);

namespace App\Product\Fetcher;

use App\Entity\Product;
use App\Shared\DTO\Pagination;

interface ProductFetcherInterface
{
    /**
     * @return Product[]
     */
    public function fetchAllWithCategoryPaginated(Pagination $pagination): array;

    public function fetchById(int $id): ?Product;
}
