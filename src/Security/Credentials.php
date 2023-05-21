<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

final class Credentials implements CredentialsInterface
{
    /**
     * @param non-empty-string $userIdentifier
     * @param non-empty-string $plainPassword
     */
    public function __construct(
        private readonly string $userIdentifier,
        private readonly string $plainPassword
    ) {
    }

    /**
     * @return non-empty-string
     */
    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @return non-empty-string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
