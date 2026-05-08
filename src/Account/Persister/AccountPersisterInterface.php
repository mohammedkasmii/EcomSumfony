<?php

declare(strict_types=1);

namespace App\Account\Persister;

use App\Entity\User;

interface AccountPersisterInterface
{
    public function persist(User $user): void;
}
