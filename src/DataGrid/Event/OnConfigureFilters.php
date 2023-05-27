<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Event;

use Spiral\AdminPanel\DataGrid\FiltersConfigurator;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;

final class OnConfigureFilters
{
    public function __construct(
        public readonly FiltersConfigurator $filters,
        public readonly GridSchemaInterface $gridSchema
    ) {
    }
}
