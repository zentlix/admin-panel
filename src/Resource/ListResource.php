<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

class ListResource implements ResourceResponse
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $template
     * @param non-empty-string|null $grid
     * @param ?non-empty-string|null $gridRoute
     */
    public function __construct(
        public readonly string $title,
        public readonly string $template = 'admin:resource/list',
        public readonly array $parameters = [],
        public readonly array $breadcrumbs = [],
        public ?string $grid = null,
        public ?string $gridRoute = null,
        public array $gridOptions = []
    ) {
    }
}
