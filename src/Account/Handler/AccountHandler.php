<?php

declare(strict_types=1);

namespace App\Account\Handler;

use App\Account\DTO\RegistrationRequest;
use App\Account\Factory\AccountFactoryInterface;
use App\Account\Persister\AccountPersisterInterface;

final readonly class AccountHandler
{
    public function __construct(
        private AccountFactoryInterface $factory,
        private AccountPersisterInterface $persister
    ) {}

    public function handleRegistration(RegistrationRequest $request): void
    {
        $user = $this->factory->createFromRequest($request);
        $this->persister->persist($user);
    }
}
