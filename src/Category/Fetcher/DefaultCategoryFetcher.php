<?php

declare(strict_types=1);

namespace App\Category\Fetcher;

use App\Entity\Category;
use App\Repository\CategoryRepository;

final readonly class DefaultCategoryFetcher implements CategoryFetcherInterface
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    /**
     * @return Category[]
     */
    public function fetchAll(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function fetchBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findOneBy(['slug' => $slug]);
    }
}
