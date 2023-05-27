<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Event;

use Spiral\AdminPanel\DataGrid\GridSchemaInterface;
use Spiral\AdminPanel\DataGrid\SortersConfigurator;

final class OnConfigureSorters
{
    public function __construct(
        public readonly SortersConfigurator $sorters,
        public readonly GridSchemaInterface $gridSchema
    ) {
    }
}
