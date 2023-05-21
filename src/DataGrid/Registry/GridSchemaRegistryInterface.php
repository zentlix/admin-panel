<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Registry;

use Spiral\AdminPanel\DataGrid\Internal\GridSchema;

interface GridSchemaRegistryInterface
{
    /**
     * @param non-empty-string $name
     */
    public function add(string $name, GridSchema $schema): void;

    /**
     * @param non-empty-string $name
     */
    public function get(string $name): GridSchema;
}
