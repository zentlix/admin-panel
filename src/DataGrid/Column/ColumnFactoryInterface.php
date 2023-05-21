<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Column;

interface ColumnFactoryInterface
{
    /**
     * @param class-string<ColumnInterface> $type
     * @param non-empty-string $name
     */
    public function make(string $type, string $name, array $options): ColumnInterface;
}
