<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

interface PaginatorConfigurator
{
    /**
     * @param int<0, max> $limit
     * @param array<array-key, int<0, max>> $allowedLimits
     */
    public function configure(int $limit, array $allowedLimits): void;
}
