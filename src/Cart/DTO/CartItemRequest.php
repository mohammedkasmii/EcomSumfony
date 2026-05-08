<?php

declare(strict_types=1);

namespace App\Cart\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CartItemRequest
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    public ?int $productId = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(10)]
    public ?int $quantity = 1;
}
