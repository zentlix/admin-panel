<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

use Spiral\DataGrid\Specification\FilterInterface;

interface FiltersConfigurator
{
    public function search(FilterInterface $filter): self;

    /**
     * @param non-empty-string $name
     * @param non-empty-string $label
     */
    public function filter(string $name, FilterInterface $filter, string $label, array $choices): self;
}
