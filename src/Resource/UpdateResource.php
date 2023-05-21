<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Resource;

class UpdateResource implements ResourceResponse
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $template
     */
    public function __construct(
        public readonly string $title,
        public readonly string $template = 'admin:resource/update',
        public readonly array $parameters = []
    ) {
    }
}
