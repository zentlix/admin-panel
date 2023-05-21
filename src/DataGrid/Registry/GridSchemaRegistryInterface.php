<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Registry;

use Spiral\AdminPanel\DataGrid\GridSchema;

interface GridSchemaRegistryInterface
{
    public function add(string $name, GridSchema $schema): void;

    public function get(string $name): GridSchema;
}
