<?php

declare(strict_types=1);

namespace App\Tests\Unit\Account\Factory;

use App\Account\DTO\RegistrationRequest;
use App\Account\Factory\DefaultAccountFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DefaultAccountFactoryTest extends TestCase
{
    public function testCreateFromRequest(): void
    {
        $hasherMock = $this->createMock(UserPasswordHasherInterface::class);
        $hasherMock->expects($this->once())
            ->method('hashPassword')
            ->willReturn('hashed_password');

        $factory = new DefaultAccountFactory($hasherMock);

        $request = new RegistrationRequest();
        $request->name = 'John Doe';
        $request->email = 'john@example.com';
        $request->plainPassword = 'Password123!';

        $user = $factory->createFromRequest($request);

        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertEquals('hashed_password', $user->getPassword());
    }
}
