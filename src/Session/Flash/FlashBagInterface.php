<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Session\Flash;

interface FlashBagInterface
{
    /**
     * Adds a flash message for the given type.
     *
     * @param non-empty-string $type
     */
    public function add(string $type, string|\Stringable $message): void;

    /**
     * Registers one or more messages for a given type.
     *
     * @param non-empty-string $type
     * @param string|\Stringable|array<string|\Stringable> $messages
     */
    public function set(string $type, string|\Stringable|array $messages): void;

    /**
     * Gets and clears flash from the stack.
     *
     * @param non-empty-string $type
     * @param array<string|\Stringable> $default Default value if $type does not exist
     */
    public function get(string $type, array $default = []): array;

    /**
     * @param non-empty-string $type
     * @param array<string|\Stringable> $default
     */
    public function peek(string $type, array $default = []): array;

    public function peekAll(): array;

    /**
     * Gets and clears flashes from the stack.
     */
    public function all(): array;

    /**
     * Has flash messages for a given type?
     *
     * @param non-empty-string $type
     */
    public function has(string $type): bool;

    /**
     * Returns a list of all defined types.
     */
    public function keys(): array;
}
