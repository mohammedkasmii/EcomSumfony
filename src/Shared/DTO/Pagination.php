<?php

declare(strict_types=1);

namespace App\Shared\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Pagination
{
    public function __construct(
        #[Assert\Positive]
        public readonly int $page = 1,

        #[Assert\Positive]
        #[Assert\LessThanOrEqual(100)]
        public readonly int $limit = 12
    ) {}
}
