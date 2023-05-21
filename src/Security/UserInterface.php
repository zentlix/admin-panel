<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

use Spiral\Security\ActorInterface;

interface UserInterface extends ActorInterface
{
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void;

    /**
     * Returns the identifier for this user (e.g. username or email address).
     *
     * @return non-empty-string
     */
    public function getUserIdentifier(): string;

    /**
     * @return non-empty-string
     */
    public function getPassword(): string;
}
