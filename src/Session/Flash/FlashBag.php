<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Session\Flash;

use Spiral\Session\SessionScope;

final class FlashBag implements FlashBagInterface
{
    /**
     * @param non-empty-string $sessionSection
     */
    public function __construct(
        private readonly SessionScope $sessionScope,
        private readonly string $sessionSection = '_spiral_flashes'
    ) {
    }

    /**
     * @param non-empty-string $type
     */
    public function add(string $type, string|\Stringable $message): void
    {
        $flashes = $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);
        $flashes[$type][] = $message;

        $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->set('flashes', $flashes);
    }

    /**
     * @param non-empty-string $type
     * @param array<string|\Stringable> $default
     */
    public function peek(string $type, array $default = []): array
    {
        return $this->has($type)
            ? $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes')[$type]
            : $default;
    }

    public function peekAll(): array
    {
        return $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);
    }

    /**
     * @param non-empty-string $type
     * @param array<string|\Stringable> $default Default value if $type does not exist
     */
    public function get(string $type, array $default = []): array
    {
        if (!$this->has($type)) {
            return $default;
        }

        $flashes = $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);
        $messages = $flashes[$type];

        unset($flashes[$type]);

        $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->set('flashes', $flashes);

        return $messages;
    }

    public function all(): array
    {
        $return = $this->peekAll();

        $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->set('flashes', []);

        return $return;
    }

    /**
     * @param non-empty-string $type
     * @param string|\Stringable|array<string|\Stringable> $messages
     */
    public function set(string $type, string|\Stringable|array $messages): void
    {
        $flashes = $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);
        $flashes[$type] = (array) $messages;

        $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->set('flashes', $flashes);
    }

    /**
     * @param non-empty-string $type
     */
    public function has(string $type): bool
    {
        $flashes = $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);

        return \array_key_exists($type, $flashes) && $flashes[$type];
    }

    public function keys(): array
    {
        $flashes = $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->get('flashes', []);

        return \array_keys($flashes);
    }

    public function clear(): void
    {
        $this->sessionScope->getActiveSession()->getSection($this->sessionSection)->set('flashes', []);
    }
}
