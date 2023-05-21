<?php

declare(strict_types=1);

namespace Spiral\AdminPanel\DataGrid\Configurator;

use Spiral\AdminPanel\DataGrid\DefaultsConfigurator as DefaultsConfiguratorInterface;

final class DefaultsConfigurator implements DefaultsConfiguratorInterface
{
    private array $defaults = [];

    public function configure(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    public function getDefaults(): array
    {
        return $this->defaults;
    }
}
