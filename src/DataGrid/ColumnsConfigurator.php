<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

use Spiral\AdminPanel\DataGrid\Column\ColumnInterface;

interface ColumnsConfigurator
{
    /**
     * @param non-empty-string $name
     * @param class-string<ColumnInterface> $type
     */
    public function add(string $name, string $type, array $options): self;
}
