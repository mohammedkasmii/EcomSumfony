<?php

declare(strict_types=1);

namespace App\Account\Factory;

use App\Account\DTO\RegistrationRequest;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class DefaultAccountFactory implements AccountFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function createFromRequest(RegistrationRequest $request): User
    {
        $user = new User();
        $user->setEmail($request->email);
        $user->setName($request->name);

        $hashed = $this->hasher->hashPassword($user, $request->plainPassword);
        $user->setPassword($hashed);

        return $user;
    }
}
