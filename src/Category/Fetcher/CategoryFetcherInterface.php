<?php

declare(strict_types=1);

namespace App\Category\Fetcher;

use App\Entity\Category;

interface CategoryFetcherInterface
{
    /**
     * @return Category[]
     */
    public function fetchAll(): array;

    public function fetchBySlug(string $slug): ?Category;
}
