<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

use Spiral\DataGrid\Specification\SorterInterface;

interface SortersConfigurator
{
    /**
     * @param non-empty-string $name
     */
    public function add(string $name, SorterInterface $sorter): self;
}
