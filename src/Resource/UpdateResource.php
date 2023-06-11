<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UpdateResource implements ResourceResponse
{
    public string $redirectTo;

    /**
     * @param non-empty-string $title
     * @param non-empty-string|class-string $component
     * @param non-empty-string $template
     * @param non-empty-string $successMessage
     * @param non-empty-string|null $redirectTo
     */
    public function __construct(
        public readonly string $title,
        public readonly mixed $resourceIdentifier,
        public readonly string $component,
        public readonly string $template = 'admin:resource/update_tabs',
        public readonly string $successMessage = 'The element was successfully updated.',
        public readonly array $parameters = [],
        public readonly array $breadcrumbs = [],
        ?string $redirectTo = null
    ) {
        if (!empty($redirectTo)) {
            $this->redirectTo = $redirectTo;
        }
    }
}
