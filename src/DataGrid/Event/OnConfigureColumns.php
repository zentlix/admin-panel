<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Event;

use Spiral\AdminPanel\DataGrid\ColumnsConfigurator;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;

final class OnConfigureColumns
{
    public function __construct(
        public readonly ColumnsConfigurator $columns,
        public readonly GridSchemaInterface $gridSchema
    ) {
    }
}
