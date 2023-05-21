<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

use Spiral\DataGrid\Specification\FilterInterface;

interface FiltersConfigurator
{
    /**
     * @param non-empty-string $name
     */
    public function add(string $name, FilterInterface $filter): self;
}
