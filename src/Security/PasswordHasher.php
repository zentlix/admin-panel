<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

final class PasswordHasher implements PasswordHasherInterface
{
    /**
     * @param non-empty-string $plainPassword
     * @return non-empty-string
     */
    public function hashPassword(string $plainPassword): string
    {
        /** @var non-empty-string $hash */
        $hash = \password_hash($plainPassword, PASSWORD_DEFAULT);

        return $hash;
    }

    /**
     * Checks if the plaintext password matches the user's password.
     *
     * @param non-empty-string $plainPassword
     * @param non-empty-string $password
     */
    public function isPasswordValid(string $plainPassword, string $password): bool
    {
        return \password_verify($plainPassword, $password);
    }
}
