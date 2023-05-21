<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Internal;

use Spiral\AdminPanel\DataGrid\GridSchemaInterface;

interface FactoryInterface
{
    /**
     * @param non-empty-string $name
     */
    public function create(string $name, GridSchemaInterface $schema): GridSchema;
}
