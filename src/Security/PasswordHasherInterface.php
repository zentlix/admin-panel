<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

interface PasswordHasherInterface
{
    /**
     * @param non-empty-string $plainPassword
     * @return non-empty-string
     */
    public function hashPassword(string $plainPassword): string;

    /**
     * Checks if the plaintext password matches the user's password.
     *
     * @param non-empty-string $plainPassword
     * @param non-empty-string $password
     */
    public function isPasswordValid(string $plainPassword, string $password): bool;
}
