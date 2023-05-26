<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Response;

use Spiral\DataGrid\GridInterface;

interface GridResponseInterface
{
    /**
     * Create response configured with Grid result.
     */
    public function withGrid(GridInterface $grid, array $options = []): self;
}
