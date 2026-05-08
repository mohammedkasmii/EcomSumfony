<?php

declare(strict_types=1);

namespace App\Account\DTO;

use App\Account\Validator\Constraints as AccountAssert;
use App\Shared\Validator\Constraints\RequiredField;
use App\Account\Validator\Constraints\PasswordField;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationRequest
{
    #[RequiredField]
    #[Assert\Length(min: 2, max: 100)]
    public ?string $name = null;

    #[RequiredField]
    #[Assert\Email(message: 'Please enter a valid email')]
    public ?string $email = null;

    #[RequiredField]
    #[PasswordField]
    public ?string $plainPassword = null;
}
