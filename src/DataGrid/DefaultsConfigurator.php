<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

interface DefaultsConfigurator
{
    /**
     * @param array{sort: array<non-empty-string, non-empty-string>} $defaults
     */
    public function configure(array $defaults): void;
}
