<?php

declare(strict_types=1);

namespace App\Account\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PasswordField extends Constraint
{
    public string $message = 'Password must be at least 8 characters long and include an uppercase letter, lowercase letter, digit, and special character (@, -, _).';
}
