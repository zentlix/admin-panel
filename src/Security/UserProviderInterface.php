<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

use Spiral\Auth\ActorProviderInterface;

interface UserProviderInterface extends ActorProviderInterface
{
    public function findByCredentials(CredentialsInterface $credentials): ?UserInterface;
}
