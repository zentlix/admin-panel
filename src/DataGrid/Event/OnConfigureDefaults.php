<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Event;

use Spiral\AdminPanel\DataGrid\DefaultsConfigurator;
use Spiral\AdminPanel\DataGrid\GridSchemaInterface;

final class OnConfigureDefaults
{
    public function __construct(
        public readonly DefaultsConfigurator $defaults,
        public readonly GridSchemaInterface $gridSchema
    ) {
    }
}
