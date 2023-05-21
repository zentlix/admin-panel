<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

interface ColumnFactoryInterface
{
    /**
     * @param non-empty-string $name
     */
    public function create(string $name, GridSchemaInterface $schema): GridSchema;
}
