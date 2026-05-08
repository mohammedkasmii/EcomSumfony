<?php

declare(strict_types=1);

namespace App\Shared\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class RequiredField extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new NotNull(),
            new NotBlank(),
            new Type('string'),
        ];
    }
}
