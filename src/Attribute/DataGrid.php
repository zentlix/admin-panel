<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\Attribute;

use Spiral\Attributes\NamedArgumentConstructor;

#[\Attribute(\Attribute::TARGET_METHOD), NamedArgumentConstructor]
final class DataGrid
{
    /**
     * @param non-empty-string $name
     */
    public function __construct(
        public readonly string $name
    ) {
    }
}
