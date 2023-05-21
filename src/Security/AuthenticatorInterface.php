<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

interface AuthenticatorInterface
{
    public function start(CredentialsInterface $credentials, \DateTimeInterface $sessionExpiration): void;

    /**
     * @param non-empty-string $token
     */
    public function close(string $token): void;
}
