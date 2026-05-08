<?php

declare(strict_types=1);

namespace App\Account\Factory;

use App\Account\DTO\RegistrationRequest;
use App\Entity\User;

interface AccountFactoryInterface
{
    public function createFromRequest(RegistrationRequest $request): User;
}
