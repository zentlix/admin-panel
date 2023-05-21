<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

interface CredentialsInterface
{
    /**
     * @return non-empty-string
     */
    public function getUserIdentifier(): string;

    /**
     * @return non-empty-string
     */
    public function getPlainPassword(): string;
}
