<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Security;

use Spiral\AdminPanel\Config\AdminPanelConfig;
use Spiral\Auth\AuthScope;
use Spiral\Auth\TokenStorageInterface;
use Spiral\AdminPanel\Exception\InvalidArgumentException;
use Spiral\AdminPanel\Exception\InvalidEmailException;
use Spiral\AdminPanel\Exception\InvalidPasswordException;
use Spiral\Translator\TranslatorInterface;

class Authenticator implements AuthenticatorInterface
{
    public function __construct(
        protected readonly UserProviderInterface $userProvider,
        protected readonly PasswordHasherInterface $passwordHasher,
        protected readonly AuthScope $authScope,
        protected readonly TokenStorageInterface $tokenStorage,
        protected readonly TranslatorInterface $translator,
        protected readonly AdminPanelConfig $config
    ) {
    }

    public function start(CredentialsInterface $credentials, \DateTimeInterface $sessionExpiration): void
    {
        $user = $this->userProvider->findByCredentials($credentials);
        if ($user === null) {
            throw new InvalidEmailException($this->translator->trans(
                'Please verify your credentials and try again.'
            ));
        }

        if (!$this->passwordHasher->isPasswordValid($credentials->getPlainPassword(), $user->getPassword())) {
            throw new InvalidPasswordException($this->translator->trans(
                'Incorrect password. Please try again.'
            ));
        }

        $token = $this->tokenStorage->create(['userID' => $user->getUserIdentifier()], $sessionExpiration);

        $this->authScope->start($token, $this->config->getAuthTransport());
    }

    public function close(string $token): void
    {
        if ($this->authScope->getToken() === null || $this->authScope->getToken()?->getID() !== $token) {
            throw new InvalidArgumentException($this->translator->trans('Incorrect Logout token.'));
        }

        $this->authScope->close();
    }
}
