<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid;

interface DefaultsConfigurator
{
    public function configure(array $defaults): void;
}
