<?php

declare(strict_types=1);

namespace App\Account\Persister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DefaultAccountPersister implements AccountPersisterInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function persist(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
