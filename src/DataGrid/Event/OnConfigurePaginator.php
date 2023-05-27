<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Event;

use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\AdminPanel\DataGrid\PaginatorConfigurator;

final class OnConfigurePaginator
{
    public function __construct(
        public readonly PaginatorConfigurator $paginator,
        public readonly GridSchemaInterface $gridSchema
    ) {
    }
}
